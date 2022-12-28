/*
 Highstock JS v10.0.0 (2022-03-07)

 Data grouping module

 (c) 2010-2021 Torstein Hnsi

 License: www.jabarsoft.com/license
*/
(function(d){"object"===typeof module&&module.exports?(d["default"]=d,module.exports=d):"function"===typeof define&&define.amd?define("highcharts/modules/datagrouping",["highcharts"],function(z){d(z);d.Highcharts=z;return d}):d("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(d){function z(d,y,g,z){d.hasOwnProperty(y)||(d[y]=z.apply(null,g),"function"===typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:y,module:d[y]}})))}d=d?d._modules:{};
z(d,"Extensions/DataGrouping.js",[d["Core/Axis/Axis.js"],d["Core/Axis/DateTimeAxis.js"],d["Core/FormatUtilities.js"],d["Core/Globals.js"],d["Core/Series/Point.js"],d["Core/Series/Series.js"],d["Core/Tooltip.js"],d["Core/DefaultOptions.js"],d["Core/Utilities.js"]],function(d,z,g,E,M,F,N,O,m){var y=g.format,r=F.prototype;g=m.addEvent;var L=m.arrayMax,P=m.arrayMin,Q=m.correctFloat,D=m.defined,G=m.error,R=m.extend,p=m.isNumber,C=m.merge,A=m.pick;"";var k=E.approximations={sum:function(a){var b=a.length;
if(!b&&a.hasNulls)var c=null;else if(b)for(c=0;b--;)c+=a[b];return c},average:function(a){var b=a.length;a=k.sum(a);p(a)&&b&&(a=Q(a/b));return a},averages:function(){var a=[];[].forEach.call(arguments,function(b){a.push(k.average(b))});return"undefined"===typeof a[0]?void 0:a},open:function(a){return a.length?a[0]:a.hasNulls?null:void 0},high:function(a){return a.length?L(a):a.hasNulls?null:void 0},low:function(a){return a.length?P(a):a.hasNulls?null:void 0},close:function(a){return a.length?a[a.length-
1]:a.hasNulls?null:void 0},hlc:function(a,b,c){a=k.high(a);b=k.low(b);c=k.close(c);if(p(a)||p(b)||p(c))return[a,b,c]},ohlc:function(a,b,c,h){a=k.open(a);b=k.high(b);c=k.low(c);h=k.close(h);if(p(a)||p(b)||p(c)||p(h))return[a,b,c,h]},range:function(a,b){a=k.low(a);b=k.high(b);if(p(a)||p(b))return[a,b];if(null===a&&null===b)return null}};m=function(a,b,c,h){var e=this,d=e.data,m=e.options&&e.options.data,f=[],H=[],I=[],t=a.length,l=!!b,n=[],u=e.pointArrayMap,g=u&&u.length,v=["x"].concat(u||["y"]),z=
this.options.dataGrouping&&this.options.dataGrouping.groupAll,B=0,r=0,w;h="function"===typeof h?h:k[h]?k[h]:k[e.getDGApproximation&&e.getDGApproximation()||"average"];g?u.forEach(function(){n.push([])}):n.push([]);var y=g||1;for(w=0;w<=t&&!(a[w]>=c[0]);w++);for(w;w<=t;w++){for(;"undefined"!==typeof c[B+1]&&a[w]>=c[B+1]||w===t;){var q=c[B];e.dataGroupInfo={start:z?r:e.cropStart+r,length:n[0].length};var A=h.apply(e,n);e.pointClass&&!D(e.dataGroupInfo.options)&&(e.dataGroupInfo.options=C(e.pointClass.prototype.optionsToObject.call({series:e},
e.options.data[e.cropStart+r])),v.forEach(function(a){delete e.dataGroupInfo.options[a]}));"undefined"!==typeof A&&(f.push(q),H.push(A),I.push(e.dataGroupInfo));r=w;for(q=0;q<y;q++)n[q].length=0,n[q].hasNulls=!1;B+=1;if(w===t)break}if(w===t)break;if(u){q=e.options.dataGrouping&&e.options.dataGrouping.groupAll?w:e.cropStart+w;A=d&&d[q]||e.pointClass.prototype.applyOptions.apply({series:e},[m[q]]);var x=void 0;for(q=0;q<g;q++)x=A[u[q]],p(x)?n[q].push(x):null===x&&(n[q].hasNulls=!0)}else q=l?b[w]:null,
p(q)?n[0].push(q):null===q&&(n[0].hasNulls=!0)}return{groupedXData:f,groupedYData:H,groupMap:I}};var J={approximations:k,groupData:m},S=r.generatePoints,x={groupPixelWidth:2,dateTimeLabelFormats:{millisecond:["%A, %b %e, %H:%M:%S.%L","%A, %b %e, %H:%M:%S.%L","-%H:%M:%S.%L"],second:["%A, %b %e, %H:%M:%S","%A, %b %e, %H:%M:%S","-%H:%M:%S"],minute:["%A, %b %e, %H:%M","%A, %b %e, %H:%M","-%H:%M"],hour:["%A, %b %e, %H:%M","%A, %b %e, %H:%M","-%H:%M"],day:["%A, %b %e, %Y","%A, %b %e","-%A, %b %e, %Y"],
week:["Week from %A, %b %e, %Y","%A, %b %e","-%A, %b %e, %Y"],month:["%B %Y","%B","-%B %Y"],year:["%Y","%Y","-%Y"]}},K={line:{},spline:{},area:{},areaspline:{},arearange:{},column:{groupPixelWidth:10},columnrange:{groupPixelWidth:10},candlestick:{groupPixelWidth:10},ohlc:{groupPixelWidth:5},hlc:{groupPixelWidth:5},heikinashi:{groupPixelWidth:10}},T=E.defaultDataGroupingUnits=[["millisecond",[1,2,5,10,20,25,50,100,200,500]],["second",[1,2,5,10,15,30]],["minute",[1,2,5,10,15,30]],["hour",[1,2,3,4,6,
8,12]],["day",[1]],["week",[1]],["month",[1,3,6]],["year",null]];r.getDGApproximation=function(){return this.is("arearange")?"range":this.is("ohlc")?"ohlc":this.is("hlc")?"hlc":this.is("column")?"sum":"average"};r.groupData=m;r.applyGrouping=function(a){var b=this.chart,c=this.options.dataGrouping,h=!1!==this.allowDG&&c&&A(c.enabled,b.options.isStock),e=this.visible||!b.options.chart.ignoreHiddenSeries,d,m=this.currentDataGrouping,f=!1;h&&!this.requireSorting&&(this.requireSorting=f=!0);a=!1===!(this.isCartesian&&
!this.isDirty&&!this.xAxis.isDirty&&!this.yAxis.isDirty&&!a)||!h;f&&(this.requireSorting=!1);if(!a){this.destroyGroupedData();h=c.groupAll?this.xData:this.processedXData;var k=c.groupAll?this.yData:this.processedYData;a=b.plotSizeX;f=this.xAxis;var g=f.options.ordinal,t=this.groupPixelWidth;if(t&&h&&h.length){this.isDirty=d=!0;this.points=null;var l=f.getExtremes();var n=l.min;l=l.max;g=g&&f.ordinal&&f.ordinal.getGroupIntervalFactor(n,l,this)||1;a=f.getTimeTicks(z.Additions.prototype.normalizeTimeTickInterval(t*
(l-n)/a*g,c.units||T),Math.min(n,h[0]),Math.max(l,h[h.length-1]),f.options.startOfWeek,h,this.closestPointRange);t=r.groupData.apply(this,[h,k,a,c.approximation]);h=t.groupedXData;k=t.groupedYData;g=0;c&&c.smoothed&&h.length&&(c.firstAnchor="firstPoint",c.anchor="middle",c.lastAnchor="lastPoint",G(32,!1,b,{"dataGrouping.smoothed":"use dataGrouping.anchor"}));b=h;var u=this.options.dataGrouping;n=this.currentDataGrouping&&this.currentDataGrouping.gapSize;if(u&&this.xData&&n&&this.groupMap){var x=b.length-
1;var v=u.anchor;var y=A(u.firstAnchor,v);u=A(u.lastAnchor,v);if(v&&"start"!==v){var B=n*{middle:.5,end:1}[v];for(v=b.length-1;v--&&0<v;)b[v]+=B}if(y&&"start"!==y&&this.xData[0]>=b[0]){v=this.groupMap[0].start;B=this.groupMap[0].length;var C=void 0;p(v)&&p(B)&&(C=v+(B-1));b[0]={middle:b[0]+.5*n,end:b[0]+n,firstPoint:this.xData[0],lastPoint:C&&this.xData[C]}[y]}u&&"start"!==u&&n&&b[x]>=l-n&&(l=this.groupMap[this.groupMap.length-1].start,b[x]={middle:b[x]+.5*n,end:b[x]+n,firstPoint:l&&this.xData[l],
lastPoint:this.xData[this.xData.length-1]}[u])}for(l=1;l<a.length;l++)a.info.segmentStarts&&-1!==a.info.segmentStarts.indexOf(l)||(g=Math.max(a[l]-a[l-1],g));l=a.info;l.gapSize=g;this.closestPointRange=a.info.totalRange;this.groupMap=t.groupMap;if(e){e=h;if(D(e[0])&&p(f.min)&&p(f.dataMin)&&e[0]<f.min){if(!D(f.options.min)&&f.min<=f.dataMin||f.min===f.dataMin)f.min=Math.min(e[0],f.min);f.dataMin=Math.min(e[0],f.dataMin)}if(D(e[e.length-1])&&p(f.max)&&p(f.dataMax)&&e[e.length-1]>f.max){if(!D(f.options.max)&&
p(f.dataMax)&&f.max>=f.dataMax||f.max===f.dataMax)f.max=Math.max(e[e.length-1],f.max);f.dataMax=Math.max(e[e.length-1],f.dataMax)}}c.groupAll&&(this.allGroupedData=k,c=this.cropData(h,k,f.min,f.max,1),h=c.xData,k=c.yData,this.cropStart=c.start);this.processedXData=h;this.processedYData=k}else this.groupMap=null;this.hasGroupedData=d;this.currentDataGrouping=l;this.preventGraphAnimation=(m&&m.totalRange)!==(l&&l.totalRange)}};r.destroyGroupedData=function(){this.groupedData&&(this.groupedData.forEach(function(a,
b){a&&(this.groupedData[b]=a.destroy?a.destroy():null)},this),this.groupedData.length=0)};r.generatePoints=function(){S.apply(this);this.destroyGroupedData();this.groupedData=this.hasGroupedData?this.points:null};d.prototype.applyGrouping=function(a){var b=this;b.series.forEach(function(c){c.groupPixelWidth=void 0;c.groupPixelWidth=b.getGroupPixelWidth&&b.getGroupPixelWidth();c.groupPixelWidth&&(c.hasProcessed=!0);c.applyGrouping(!!a.hasExtemesChanged)})};d.prototype.getGroupPixelWidth=function(){var a=
this.series,b=a.length,c,h=0,e=!1,d;for(c=b;c--;)(d=a[c].options.dataGrouping)&&(h=Math.max(h,A(d.groupPixelWidth,x.groupPixelWidth)));for(c=b;c--;)if(d=a[c].options.dataGrouping)if(b=(a[c].processedXData||a[c].data).length,a[c].groupPixelWidth||b>this.chart.plotSizeX/h||b&&d.forced)e=!0;return e?h:0};d.prototype.setDataGrouping=function(a,b){var c;b=A(b,!0);a||(a={forced:!1,units:null});if(this instanceof d)for(c=this.series.length;c--;)this.series[c].update({dataGrouping:a},!1);else this.chart.options.series.forEach(function(b){b.dataGrouping=
"boolean"===typeof a?a:C(a,b.dataGrouping)});this.ordinal&&(this.ordinal.slope=void 0);b&&this.chart.redraw()};g(d,"postProcessData",d.prototype.applyGrouping);g(M,"update",function(){if(this.dataGroup)return G(24,!1,this.series.chart),!1});g(N,"headerFormatter",function(a){var b=this.chart,c=b.time,d=a.labelConfig,e=d.series,g=e.tooltipOptions,k=e.options.dataGrouping,f=g.xDateFormat,m=e.xAxis,r=g[a.isFooter?"footerFormat":"headerFormat"];if(m&&"datetime"===m.options.type&&k&&p(d.key)){var t=e.currentDataGrouping;
k=k.dateTimeLabelFormats||x.dateTimeLabelFormats;if(t)if(g=k[t.unitName],1===t.count)f=g[0];else{f=g[1];var l=g[2]}else!f&&k&&m.dateTime&&(f=m.dateTime.getXDateFormat(d.x,g.dateTimeLabelFormats));f=c.dateFormat(f,d.key);l&&(f+=c.dateFormat(l,d.key+t.totalRange-1));e.chart.styledMode&&(r=this.styledModeFormat(r));a.text=y(r,{point:R(d.point,{key:f}),series:e},b);a.preventDefault()}});g(F,"destroy",r.destroyGroupedData);g(F,"afterSetOptions",function(a){a=a.options;var b=this.type,c=this.chart.options.plotOptions,
d=O.defaultOptions.plotOptions[b].dataGrouping,e=this.useCommonDataGrouping&&x;if(c&&(K[b]||e)){d||(d=C(x,K[b]));var g=this.chart.rangeSelector;a.dataGrouping=C(e,d,c.series&&c.series.dataGrouping,c[b].dataGrouping,this.userOptions.dataGrouping,!a.isInternal&&g&&p(g.selected)&&g.buttonOptions[g.selected].dataGrouping)}});g(d,"afterSetScale",function(){this.series.forEach(function(a){a.hasProcessed=!1})});E.dataGrouping=J;"";return J});z(d,"masters/modules/datagrouping.src.js",[d["Extensions/DataGrouping.js"]],
function(d){return d})});
//# sourceMappingURL=datagrouping.js.map