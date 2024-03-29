/**
 * @license Highmaps JS v10.0.0 (2022-03-07)
 * @module highcharts/modules/heatmap
 * @requires highcharts
 *
 * (c) 2009-2021 Torstein Honsi
 *
 * License: www.jabarsoft.com/license
 */
'use strict';
import Highcharts from '../../Core/Globals.js';
import ColorAxis from '../../Core/Axis/Color/ColorAxis.js';
import '../../Series/Heatmap/HeatmapSeries.js';
var G = Highcharts;
G.ColorAxis = ColorAxis;
ColorAxis.compose(G.Chart, G.Fx, G.Legend, G.Series);
