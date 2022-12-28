/**
 * @license Highcharts JS v10.0.0 (2022-03-07)
 *
 * Highcharts variwide module
 *
 * (c) 2010-2021 Torstein Honsi
 *
 * License: www.jabarsoft.com/license
 */
(function (factory) {
    if (typeof module === 'object' && module.exports) {
        factory['default'] = factory;
        module.exports = factory;
    } else if (typeof define === 'function' && define.amd) {
        define('highcharts/modules/variwide', ['highcharts'], function (Highcharts) {
            factory(Highcharts);
            factory.Highcharts = Highcharts;
            return factory;
        });
    } else {
        factory(typeof Highcharts !== 'undefined' ? Highcharts : undefined);
    }
}(function (Highcharts) {
    'use strict';
    var _modules = Highcharts ? Highcharts._modules : {};
    function _registerModule(obj, path, args, fn) {
        if (!obj.hasOwnProperty(path)) {
            obj[path] = fn.apply(null, args);

            if (typeof CustomEvent === 'function') {
                window.dispatchEvent(
                    new CustomEvent(
                        'HighchartsModuleLoaded',
                        { detail: { path: path, module: obj[path] }
                    })
                );
            }
        }
    }
    _registerModule(_modules, 'Series/Variwide/VariwidePoint.js', [_modules['Core/Series/SeriesRegistry.js'], _modules['Core/Utilities.js']], function (SeriesRegistry, U) {
        /* *
         *
         *  Highcharts variwide module
         *
         *  (c) 2010-2021 Torstein Honsi
         *
         *  License: www.jabarsoft.com/license
         *
         *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
         *
         * */
        var __extends = (this && this.__extends) || (function () {
                var extendStatics = function (d,
            b) {
                    extendStatics = Object.setPrototypeOf ||
                        ({ __proto__: [] } instanceof Array && function (d,
            b) { d.__proto__ = b; }) ||
                        function (d,
            b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
                return extendStatics(d, b);
            };
            return function (d, b) {
                extendStatics(d, b);
                function __() { this.constructor = d; }
                d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
            };
        })();
        var ColumnSeries = SeriesRegistry.seriesTypes.column;
        var isNumber = U.isNumber;
        /* *
         *
         * Class
         *
         * */
        var VariwidePoint = /** @class */ (function (_super) {
                __extends(VariwidePoint, _super);
            function VariwidePoint() {
                var _this = _super !== null && _super.apply(this,
                    arguments) || this;
                /* *
                 *
                 * Properites
                 *
                 * */
                _this.crosshairWidth = void 0;
                _this.options = void 0;
                _this.series = void 0;
                return _this;
            }
            /* *
             *
             * Functions
             *
             * */
            VariwidePoint.prototype.isValid = function () {
                return isNumber(this.y) && isNumber(this.z);
            };
            return VariwidePoint;
        }(ColumnSeries.prototype.pointClass));
        /* *
         *
         * Export
         *
         * */

        return VariwidePoint;
    });
    _registerModule(_modules, 'Series/Variwide/VariwideComposition.js', [_modules['Core/Axis/Tick.js'], _modules['Core/Axis/Axis.js'], _modules['Core/Utilities.js']], function (Tick, Axis, U) {
        /* *
         *
         *  Highcharts variwide module
         *
         *  (c) 2010-2021 Torstein Honsi
         *
         *  License: www.jabarsoft.com/license
         *
         *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
         *
         * */
        var addEvent = U.addEvent,
            wrap = U.wrap;
        /* *
         *
         * Composition
         *
         * */
        Tick.prototype.postTranslate = function (xy, xOrY, index) {
            var axis = this.axis;
            var pos = xy[xOrY] - axis.pos;
            if (!axis.horiz) {
                pos = axis.len - pos;
            }
            pos = axis.series[0].postTranslate(index, pos);
            if (!axis.horiz) {
                pos = axis.len - pos;
            }
            xy[xOrY] = axis.pos + pos;
        };
        /* eslint-disable no-invalid-this */
        // Same width as the category (#8083)
        addEvent(Axis, 'afterDrawCrosshair', function (e) {
            if (this.variwide && this.cross) {
                this.cross.attr('stroke-width', (e.point && e.point.crosshairWidth));
            }
        });
        // On a vertical axis, apply anti-collision logic to the labels.
        addEvent(Axis, 'afterRender', function () {
            var axis = this;
            if (!this.horiz && this.variwide) {
                this.chart.labelCollectors.push(function () {
                    return axis.tickPositions
                        .filter(function (pos) {
                        return axis.ticks[pos].label;
                    })
                        .map(function (pos, i) {
                        var label = axis.ticks[pos].label;
                        label.labelrank = axis.zData[i];
                        return label;
                    });
                });
            }
        });
        addEvent(Tick, 'afterGetPosition', function (e) {
            var axis = this.axis,
                xOrY = axis.horiz ? 'x' : 'y';
            if (axis.variwide) {
                this[xOrY + 'Orig'] = e.pos[xOrY];
                this.postTranslate(e.pos, xOrY, this.pos);
            }
        });
        wrap(Tick.prototype, 'getLabelPosition', function (proceed, x, y, label, horiz, labelOptions, tickmarkOffset, index) {
            var args = Array.prototype.slice.call(arguments, 1),
                xy,
                xOrY = horiz ? 'x' : 'y';
            // Replace the x with the original x
            if (this.axis.variwide &&
                typeof this[xOrY + 'Orig'] === 'number') {
                args[horiz ? 0 : 1] = this[xOrY + 'Orig'];
            }
            xy = proceed.apply(this, args);
            // Post-translate
            if (this.axis.variwide && this.axis.categories) {
                this.postTranslate(xy, xOrY, this.pos);
            }
            return xy;
        });

    });
    _registerModule(_modules, 'Series/Variwide/VariwideSeries.js', [_modules['Core/Series/SeriesRegistry.js'], _modules['Series/Variwide/VariwidePoint.js'], _modules['Core/Utilities.js']], function (SeriesRegistry, VariwidePoint, U) {
        /* *
         *
         *  Highcharts variwide module
         *
         *  (c) 2010-2021 Torstein Honsi
         *
         *  License: www.jabarsoft.com/license
         *
         *  !!!!!!! SOURCE GETS TRANSPILED BY TYPESCRIPT. EDIT TS FILE ONLY. !!!!!!!
         *
         * */
        var __extends = (this && this.__extends) || (function () {
                var extendStatics = function (d,
            b) {
                    extendStatics = Object.setPrototypeOf ||
                        ({ __proto__: [] } instanceof Array && function (d,
            b) { d.__proto__ = b; }) ||
                        function (d,
            b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
                return extendStatics(d, b);
            };
            return function (d, b) {
                extendStatics(d, b);
                function __() { this.constructor = d; }
                d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
            };
        })();
        var ColumnSeries = SeriesRegistry.seriesTypes.column;
        var extend = U.extend,
            merge = U.merge,
            pick = U.pick;
        /* *
         *
         *  Class
         *
         * */
        /**
         * @private
         * @class
         * @name Highcharts.seriesTypes.variwide
         *
         * @augments Highcharts.Series
         */
        var VariwideSeries = /** @class */ (function (_super) {
                __extends(VariwideSeries, _super);
            function VariwideSeries() {
                var _this = _super !== null && _super.apply(this,
                    arguments) || this;
                /* *
                 *
                 * Properties
                 *
                 * */
                _this.data = void 0;
                _this.options = void 0;
                _this.points = void 0;
                _this.relZ = void 0;
                _this.totalZ = void 0;
                _this.zData = void 0;
                return _this;
            }
            /* *
             *
             * Functions
             *
             * */
            VariwideSeries.prototype.processData = function (force) {
                this.totalZ = 0;
                this.relZ = [];
                SeriesRegistry.seriesTypes.column.prototype.processData.call(this, force);
                (this.xAxis.reversed ?
                    this.zData.slice().reverse() :
                    this.zData).forEach(function (z, i) {
                    this.relZ[i] = this.totalZ;
                    this.totalZ += z;
                }, this);
                if (this.xAxis.categories) {
                    this.xAxis.variwide = true;
                    this.xAxis.zData = this.zData; // Used for label rank
                }
                return;
            };
            /* eslint-disable valid-jsdoc */
            /**
             * Translate an x value inside a given category index into the distorted
             * axis translation.
             *
             * @private
             * @function Highcharts.Series#postTranslate
             *
             * @param {number} index
             *        The category index
             *
             * @param {number} x
             *        The X pixel position in undistorted axis pixels
             *
             * @param {Highcharts.Point} point
             *        For crosshairWidth for every point
             *
             * @return {number}
             *         Distorted X position
             */
            VariwideSeries.prototype.postTranslate = function (index, x, point) {
                var axis = this.xAxis,
                    relZ = this.relZ,
                    i = axis.reversed ? relZ.length - index : index,
                    goRight = axis.reversed ? -1 : 1,
                    minPx = axis.toPixels(axis.reversed ?
                        (axis.dataMax || 0) + axis.pointRange :
                        (axis.dataMin || 0)),
                    maxPx = axis.toPixels(axis.reversed ?
                        (axis.dataMin || 0) :
                        (axis.dataMax || 0) + axis.pointRange),
                    len = Math.abs(maxPx - minPx),
                    totalZ = this.totalZ,
                    left = this.chart.inverted ?
                        maxPx - (this.chart.plotTop - goRight * axis.minPixelPadding) :
                        minPx - this.chart.plotLeft - goRight * axis.minPixelPadding,
                    linearSlotLeft = i / relZ.length * len,
                    linearSlotRight = (i + goRight) / relZ.length * len,
                    slotLeft = (pick(relZ[i],
                    totalZ) / totalZ) * len,
                    slotRight = (pick(relZ[i + goRight],
                    totalZ) / totalZ) * len,
                    xInsideLinearSlot = (x - (left + linearSlotLeft));
                // Set crosshairWidth for every point (#8173)
                if (point) {
                    point.crosshairWidth = slotRight - slotLeft;
                }
                return left + slotLeft +
                    xInsideLinearSlot * (slotRight - slotLeft) /
                        (linearSlotRight - linearSlotLeft);
            };
            /* eslint-enable valid-jsdoc */
            // Extend translation by distoring X position based on Z.
            VariwideSeries.prototype.translate = function () {
                // Temporarily disable crisping when computing original shapeArgs
                var crispOption = this.options.crisp,
                    xAxis = this.xAxis;
                this.options.crisp = false;
                SeriesRegistry.seriesTypes.column.prototype.translate.call(this);
                // Reset option
                this.options.crisp = crispOption;
                var inverted = this.chart.inverted,
                    crisp = this.borderWidth % 2 / 2;
                // Distort the points to reflect z dimension
                this.points.forEach(function (point, i) {
                    var left,
                        right;
                    if (xAxis.variwide) {
                        left = this.postTranslate(i, point.shapeArgs.x, point);
                        right = this.postTranslate(i, point.shapeArgs.x +
                            point.shapeArgs.width);
                        // For linear or datetime axes, the variwide column should
                        // start with X and extend Z units, without modifying the
                        // axis.
                    }
                    else {
                        left = point.plotX;
                        right = xAxis.translate(point.x + point.z, 0, 0, 0, 1);
                    }
                    if (this.options.crisp) {
                        left = Math.round(left) - crisp;
                        right = Math.round(right) - crisp;
                    }
                    point.shapeArgs.x = left;
                    point.shapeArgs.width = Math.max(right - left, 1);
                    // Crosshair position (#8083)
                    point.plotX = (left + right) / 2;
                    // Adjust the tooltip position
                    if (!inverted) {
                        point.tooltipPos[0] =
                            point.shapeArgs.x +
                                point.shapeArgs.width / 2;
                    }
                    else {
                        point.tooltipPos[1] =
                            xAxis.len - point.shapeArgs.x -
                                point.shapeArgs.width / 2;
                    }
                }, this);
                if (this.options.stacking) {
                    this.correctStackLabels();
                }
            };
            // Function that corrects stack labels positions
            VariwideSeries.prototype.correctStackLabels = function () {
                var series = this,
                    options = series.options,
                    yAxis = series.yAxis,
                    pointStack,
                    pointWidth,
                    stack,
                    xValue;
                series.points.forEach(function (point) {
                    xValue = point.x;
                    pointWidth = point.shapeArgs.width;
                    stack = yAxis.stacking.stacks[(series.negStacks &&
                        point.y < (options.startFromThreshold ?
                            0 :
                            options.threshold) ?
                        '-' :
                        '') + series.stackKey];
                    if (stack) {
                        pointStack = stack[xValue];
                        if (pointStack && !point.isNull) {
                            pointStack.setOffset(-(pointWidth / 2) || 0, pointWidth || 0, void 0, void 0, point.plotX);
                        }
                    }
                });
            };
            /* *
             *
             * Static properties
             *
             * */
            /**
             * A variwide chart (related to marimekko chart) is a column chart with a
             * variable width expressing a third dimension.
             *
             * @sample {highcharts} highcharts/demo/variwide/
             *         Variwide chart
             * @sample {highcharts} highcharts/series-variwide/inverted/
             *         Inverted variwide chart
             * @sample {highcharts} highcharts/series-variwide/datetime/
             *         Variwide columns on a datetime axis
             *
             * @extends      plotOptions.column
             * @since        6.0.0
             * @product      highcharts
             * @excluding    boostThreshold, crisp, depth, edgeColor, edgeWidth,
             *               groupZPadding, boostBlending
             * @requires     modules/variwide
             * @optionparent plotOptions.variwide
             */
            VariwideSeries.defaultOptions = merge(ColumnSeries.defaultOptions, {
                /**
                 * In a variwide chart, the point padding is 0 in order to express the
                 * horizontal stacking of items.
                 */
                pointPadding: 0,
                /**
                 * In a variwide chart, the group padding is 0 in order to express the
                 * horizontal stacking of items.
                 */
                groupPadding: 0
            });
            return VariwideSeries;
        }(ColumnSeries));
        extend(VariwideSeries.prototype, {
            irregularWidths: true,
            pointArrayMap: ['y', 'z'],
            parallelArrays: ['x', 'y', 'z'],
            pointClass: VariwidePoint
        });
        SeriesRegistry.registerSeriesType('variwide', VariwideSeries);
        /* *
         *
         * Default export
         *
         * */
        /* *
         *
         * API Options
         *
         * */
        /**
         * A `variwide` series. If the [type](#series.variwide.type) option is not
         * specified, it is inherited from [chart.type](#chart.type).
         *
         * @extends   series,plotOptions.variwide
         * @excluding boostThreshold, boostBlending
         * @product   highcharts
         * @requires  modules/variwide
         * @apioption series.variwide
         */
        /**
         * An array of data points for the series. For the `variwide` series type,
         * points can be given in the following ways:
         *
         * 1. An array of arrays with 3 or 2 values. In this case, the values correspond
         *    to `x,y,z`. If the first value is a string, it is applied as the name of
         *    the point, and the `x` value is inferred. The `x` value can also be
         *    omitted, in which case the inner arrays should be of length 2. Then the
         *    `x` value is automatically calculated, either starting at 0 and
         *    incremented by 1, or from `pointStart` and `pointInterval` given in the
         *    series options.
         *    ```js
         *       data: [
         *           [0, 1, 2],
         *           [1, 5, 5],
         *           [2, 0, 2]
         *       ]
         *    ```
         *
         * 2. An array of objects with named values. The following snippet shows only a
         *    few settings, see the complete options set below. If the total number of
         *    data points exceeds the series'
         *    [turboThreshold](#series.variwide.turboThreshold), this option is not
         *    available.
         *    ```js
         *       data: [{
         *           x: 1,
         *           y: 1,
         *           z: 1,
         *           name: "Point2",
         *           color: "#00FF00"
         *       }, {
         *           x: 1,
         *           y: 5,
         *           z: 4,
         *           name: "Point1",
         *           color: "#FF00FF"
         *       }]
         *    ```
         *
         * @sample {highcharts} highcharts/series/data-array-of-arrays/
         *         Arrays of numeric x and y
         * @sample {highcharts} highcharts/series/data-array-of-arrays-datetime/
         *         Arrays of datetime x and y
         * @sample {highcharts} highcharts/series/data-array-of-name-value/
         *         Arrays of point.name and y
         * @sample {highcharts} highcharts/series/data-array-of-objects/
         *         Config objects
         *
         * @type      {Array<Array<(number|string),number>|Array<(number|string),number,number>|*>}
         * @extends   series.line.data
         * @excluding marker
         * @product   highcharts
         * @apioption series.variwide.data
         */
        /**
         * The relative width for each column. On a category axis, the widths are
         * distributed so they sum up to the X axis length. On linear and datetime axes,
         * the columns will be laid out from the X value and Z units along the axis.
         *
         * @type      {number}
         * @product   highcharts
         * @apioption series.variwide.data.z
         */
        ''; // adds doclets above to transpiled file

        return VariwideSeries;
    });
    _registerModule(_modules, 'masters/modules/variwide.src.js', [], function () {


    });
}));