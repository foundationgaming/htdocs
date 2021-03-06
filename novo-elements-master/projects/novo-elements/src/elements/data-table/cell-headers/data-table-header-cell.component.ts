import {
  ChangeDetectionStrategy,
  ChangeDetectorRef,
  Component,
  Input,
  Optional,
  OnDestroy,
  OnInit,
  ViewChild,
  ElementRef,
  Renderer2,
  EventEmitter,
  Output,
  HostBinding,
  TemplateRef,
} from '@angular/core';
import { CdkColumnDef } from '@angular/cdk/table';
import { fromEvent, Subscription } from 'rxjs';
import * as dateFns from 'date-fns';

import {
  IDataTableSortFilter,
  IDataTableChangeEvent,
  IDataTableColumn,
  IDataTableColumnFilterOption,
  IDataTableColumnFilterConfig,
  IDataTableColumnSortConfig,
} from '../interfaces';
import { NovoDataTableSortFilter } from '../sort-filter/sort-filter.directive';
import { NovoDropdownElement } from '../../dropdown/Dropdown';
import { NovoLabelService } from '../../../services/novo-label-service';
import { DataTableState } from '../state/data-table-state.service';
import { Helpers } from '../../../utils/Helpers';

@Component({
  selector: '[novo-data-table-cell-config]',
  template: `
        <i class="bhi-{{ labelIcon }} label-icon" *ngIf="labelIcon" data-automation-id="novo-data-table-header-icon"></i>
        <label data-automation-id="novo-data-table-label">{{ label }}</label>
        <div>
            <button *ngIf="config.sortable" tooltipPosition="right" [tooltip]="labels.sort" theme="icon" [icon]="icon" (click)="sort()" [class.active]="sortActive" data-automation-id="novo-data-table-sort"></button>
            <novo-dropdown *ngIf="config.filterable" side="right" parentScrollSelector=".novo-data-table-container" containerClass="data-table-dropdown" data-automation-id="novo-data-table-filter">
                <button type="button" theme="icon" icon="filter" [class.active]="filterActive" (click)="focusInput()" tooltipPosition="right" [tooltip]="labels.filters"></button>
                <div class="header">
                    <span>{{ labels.filters }}</span>
                    <button theme="dialogue" color="negative" icon="times" (click)="clearFilter()" *ngIf="filter !== null && filter !== undefined && filter !== ''" data-automation-id="novo-data-table-filter-clear">{{ labels.clear }}</button>
                </div>
                <ng-container [ngSwitch]="config.filterConfig.type">
                    <list *ngSwitchCase="'date'">
                        <ng-container *ngIf="!showCustomRange">
                            <item [class.active]="activeDateFilter === option.label" *ngFor="let option of config.filterConfig.options" (click)="filterData(option)" [attr.data-automation-id]="'novo-data-table-filter-' + option.label">
                                {{ option.label }} <i class="bhi-check" *ngIf="activeDateFilter === option.label"></i>
                            </item>
                        </ng-container>
                        <item [class.active]="labels.customDateRange === activeDateFilter" (click)="toggleCustomRange($event, true)" *ngIf="config.filterConfig.allowCustomRange && !showCustomRange" [keepOpen]="true">
                            {{ labels.customDateRange }} <i class="bhi-check" *ngIf="labels.customDateRange === activeDateFilter"></i>
                        </item>
                        <div class="calendar-container" *ngIf="showCustomRange">
                            <div (click)="toggleCustomRange($event, false)"><i class="bhi-previous"></i>{{ labels.backToPresetFilters }}</div>
                            <novo-date-picker (onSelect)="filterData($event)" [(ngModel)]="filter" range="true"></novo-date-picker>
                        </div>
                    </list>
                    <list *ngSwitchCase="'select'">
                        <item [class.active]="filter === option" *ngFor="let option of config.filterConfig.options" (click)="filterData(option)" [attr.data-automation-id]="'novo-data-table-filter-' + (option?.label || option)">
                            <span>{{ option?.label || option }}</span> <i class="bhi-check" *ngIf="option.hasOwnProperty('value') ? filter === option.value : filter === option"></i>
                        </item>
                    </list>
                    <list *ngSwitchCase="'custom'">
                        <item class="filter-search" keepOpen="true">
                            <ng-container *ngTemplateOutlet="filterTemplate; context: {$implicit: config}"></ng-container>
                        </item>
                    </list>
                    <list *ngSwitchDefault>
                        <item class="filter-search" keepOpen="true">
                            <input [type]="config.filterConfig.type" [(ngModel)]="filter" (ngModelChange)="filterData($event)" #filterInput data-automation-id="novo-data-table-filter-input"/>
                        </item>
                    </list>
                </ng-container>
            </novo-dropdown>
        </div>
        <div class="spacer"></div>
        <div class="data-table-header-resizable" *ngIf="config.resizable">
          <span (mousedown)="startResize($event)" >&nbsp;</span>
        </div>
    `,
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class NovoDataTableCellHeader<T> implements IDataTableSortFilter, OnInit, OnDestroy {
  @ViewChild('filterInput')
  filterInput: ElementRef;
  @ViewChild(NovoDropdownElement)
  dropdown: NovoDropdownElement;

  @Input()
  defaultSort: { id: string; value: string };

  @Input()
  resized: EventEmitter<IDataTableColumn<T>>;
  @Input()
  filterTemplate: TemplateRef<any>;
  @HostBinding('class.resizable')
  public resizable: boolean;

  @Input('novo-data-table-cell-config')
  set column(column: IDataTableColumn<T>) {
    this._column = column;
    this.label = column.type === 'action' ? '' : column.label;
    this.labelIcon = column.labelIcon;

    this.config = {
      sortable: !!column.sortable,
      filterable: !!column.filterable,
      resizable: !!column.resizable,
    };
    this.resizable = this.config.resizable;

    let transforms: { filter?: Function; sort?: Function } = {};

    if (column.filterable && Helpers.isObject(column.filterable)) {
      this.config.filterConfig = column.filterable as IDataTableColumnFilterConfig;
      if (!this.config.filterConfig.type) {
        this.config.filterConfig = { type: 'text' };
      }
      if ((column.filterable as IDataTableColumnFilterConfig).transform) {
        transforms.filter = (column.filterable as IDataTableColumnFilterConfig).transform;
      }
    } else {
      this.config.filterConfig = { type: 'text' };
    }

    if (column.sortable && Helpers.isObject(column.sortable)) {
      if ((column.sortable as IDataTableColumnSortConfig).transform) {
        transforms.sort = (column.sortable as IDataTableColumnSortConfig).transform;
      }
    }

    if (this.config.filterConfig.type === 'date' && !this.config.filterConfig.options) {
      this.config.filterConfig.options = this.getDefaultDateFilterOptions();
    }

    this.config.transforms = transforms;
  }

  private _rerenderSubscription: Subscription;
  private changeTimeout: any;

  public label: string;
  public icon: string = 'sortable';
  public labelIcon: string;
  public id: string;
  public filter: any;
  public direction: string;
  public filterActive: boolean = false;
  public sortActive: boolean = false;
  public showCustomRange: boolean = false;
  public activeDateFilter: string;
  public config: {
    sortable: boolean;
    filterable: boolean;
    resizable: boolean;
    transforms?: { filter?: Function; sort?: Function };
    filterConfig?: IDataTableColumnFilterConfig;
  };
  private subscriptions: Subscription[] = [];
  private _column: IDataTableColumn<T>;

  constructor(
    private changeDetectorRef: ChangeDetectorRef,
    public labels: NovoLabelService,
    private state: DataTableState<T>,
    private renderer: Renderer2,
    private elementRef: ElementRef,
    @Optional() public _sort: NovoDataTableSortFilter<T>,
    @Optional() public _cdkColumnDef: CdkColumnDef,
  ) {
    this._rerenderSubscription = state.updates.subscribe((change: IDataTableChangeEvent) => {
      if (change.sort && change.sort.id === this.id) {
        this.icon = `sort-${change.sort.value}`;
        this.sortActive = true;
      } else {
        this.icon = 'sortable';
        this.sortActive = false;
      }
      if (change.filter && change.filter.id === this.id) {
        this.filterActive = true;
        this.filter = change.filter.value;
      } else {
        this.filterActive = false;
        this.filter = undefined;
      }
      changeDetectorRef.markForCheck();
    });
  }

  public ngOnInit(): void {
    if (this._cdkColumnDef) {
      this.id = this._cdkColumnDef.name;
    }
    if (this.defaultSort && this.id === this.defaultSort.id) {
      this.icon = `sort-${this.defaultSort.value}`;
      this.sortActive = true;
      this.changeDetectorRef.markForCheck();
    }
  }

  public ngOnDestroy(): void {
    this._rerenderSubscription.unsubscribe();
    this.subscriptions.forEach((subscription: Subscription) => {
      subscription.unsubscribe();
    });
  }

  public startResize(mouseDownEvent: MouseEvent): void {
    mouseDownEvent.preventDefault();
    const minimumWidth = 60 + (this.config.filterable ? 30 : 0) + (this.config.sortable ? 30 : 0);
    let startingWidth: number = this.elementRef.nativeElement.getBoundingClientRect().width;
    const mouseMoveSubscription: Subscription = fromEvent(window.document, 'mousemove').subscribe((middleMouseEvent: MouseEvent) => {
      let differenceWidth: number = middleMouseEvent.clientX - mouseDownEvent.clientX;
      let width: number = startingWidth + differenceWidth;
      if (width < minimumWidth) {
        width = minimumWidth;
      }
      this._column.width = width;
      this.renderer.setStyle(this.elementRef.nativeElement, 'min-width', `${this._column.width}px`);
      this.renderer.setStyle(this.elementRef.nativeElement, 'max-width', `${this._column.width}px`);
      this.renderer.setStyle(this.elementRef.nativeElement, 'width', `${this._column.width}px`);
      this.changeDetectorRef.markForCheck();
      this.resized.next(this._column);
    });

    let mouseUpSubscription: Subscription = fromEvent(window.document, 'mouseup').subscribe(() => {
      mouseUpSubscription.unsubscribe();
      mouseMoveSubscription.unsubscribe();
      this.changeDetectorRef.markForCheck();
    });
    this.subscriptions.push(mouseMoveSubscription);
    this.subscriptions.push(mouseUpSubscription);
  }

  public toggleCustomRange(event: Event, value: boolean): void {
    Helpers.swallowEvent(event);
    this.showCustomRange = value;
    this.changeDetectorRef.markForCheck();
    this.dropdown.openPanel(); // Ensures that the panel correctly updates to the dynamic size of the dropdown
  }

  public focusInput(): void {
    if (this.filterInput && this.filterInput.nativeElement) {
      setTimeout(() => this.filterInput.nativeElement.focus(), 0);
    }
  }

  public sort(): void {
    if (this.changeTimeout) {
      clearTimeout(this.changeTimeout);
    }
    this.changeTimeout = setTimeout(() => {
      this.direction = this.getNextSortDirection(this.direction);
      this._sort.sort(this.id, this.direction, this.config.transforms.sort);
      this.changeDetectorRef.markForCheck();
    }, 300);
  }

  public filterData(filter?: any): void {
    let actualFilter = filter;
    if (this.config.filterConfig.type === 'date' && filter) {
      this.activeDateFilter = filter.label || this.labels.customDateRange;
      if (filter.startDate && filter.endDate) {
        actualFilter = {
          min: dateFns.startOfDay(filter.startDate.date),
          max: dateFns.startOfDay(dateFns.addDays(dateFns.startOfDay(filter.endDate.date), 1)),
        };
      } else {
        actualFilter = {
          min: filter.min ? dateFns.addDays(dateFns.startOfToday(), filter.min) : dateFns.startOfToday(),
          max: filter.max ? dateFns.addDays(dateFns.endOfToday(), filter.max) : dateFns.endOfToday(),
        };
      }
    }

    if (actualFilter && actualFilter.hasOwnProperty('value')) {
      actualFilter = filter.value;
    }

    if (this.changeTimeout) {
      clearTimeout(this.changeTimeout);
    }

    this.changeTimeout = setTimeout(() => {
      if (actualFilter === '') {
        actualFilter = undefined;
      }
      this._sort.filter(this.id, actualFilter, this.config.transforms.filter);
      this.changeDetectorRef.markForCheck();
    }, 300);
  }

  public clearFilter(): void {
    this.filter = undefined;
    this.activeDateFilter = undefined;
    this.filterData(undefined);
  }

  private getNextSortDirection(direction: string): string {
    if (!direction) {
      return 'asc';
    }
    if (direction === 'asc') {
      return 'desc';
    }
    return 'asc';
  }

  private getDefaultDateFilterOptions(): IDataTableColumnFilterOption[] {
    let opts: IDataTableColumnFilterOption[] = [
      { label: this.labels.past1Day, min: -1, max: 0 },
      { label: this.labels.past7Days, min: -7, max: 0 },
      { label: this.labels.past30Days, min: -30, max: 0 },
      { label: this.labels.past90Days, min: -90, max: 0 },
      { label: this.labels.past1Year, min: -366, max: 0 },
      { label: this.labels.next1Day, min: 0, max: 1 },
      { label: this.labels.next7Days, min: 0, max: 7 },
      { label: this.labels.next30Days, min: 0, max: 30 },
      { label: this.labels.next90Days, min: 0, max: 90 },
      { label: this.labels.next1Year, min: 0, max: 366 },
    ];
    return opts;
  }
}
