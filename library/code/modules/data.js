/*
 Highcharts JS v10.0.0 (2022-03-07)

 Data module

 (c) 2012-2021 Torstein Honsi

 License: www.jabarsoft.com/license
*/
(function(c){"object"===typeof module&&module.exports?(c["default"]=c,module.exports=c):"function"===typeof define&&define.amd?define("highcharts/modules/data",["highcharts"],function(p){c(p);c.Highcharts=p;return c}):c("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(c){function p(c,e,y,p){c.hasOwnProperty(e)||(c[e]=p.apply(null,y),"function"===typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:e,module:c[e]}})))}c=c?c._modules:{};p(c,"Core/HttpUtilities.js",
[c["Core/Globals.js"],c["Core/Utilities.js"]],function(c,e){var y=c.doc,p=e.createElement,v=e.discardElement,q=e.merge,D=e.objectEach,E={ajax:function(c){var m=q(!0,{url:!1,type:"get",dataType:"json",success:!1,error:!1,data:!1,headers:{}},c);c={json:"application/json",xml:"application/xml",text:"text/plain",octet:"application/octet-stream"};var e=new XMLHttpRequest;if(!m.url)return!1;e.open(m.type.toUpperCase(),m.url,!0);m.headers["Content-Type"]||e.setRequestHeader("Content-Type",c[m.dataType]||
c.text);D(m.headers,function(c,m){e.setRequestHeader(m,c)});m.responseType&&(e.responseType=m.responseType);e.onreadystatechange=function(){if(4===e.readyState){if(200===e.status){if("blob"!==m.responseType){var c=e.responseText;if("json"===m.dataType)try{c=JSON.parse(c)}catch(F){m.error&&m.error(e,F);return}}return m.success&&m.success(c,e)}m.error&&m.error(e,e.responseText)}};try{m.data=JSON.stringify(m.data)}catch(z){}e.send(m.data||!0)},getJSON:function(c,e){E.ajax({url:c,success:e,dataType:"json",
headers:{"Content-Type":"text/plain"}})},post:function(c,e,E){var m=p("form",q({method:"post",action:c,enctype:"multipart/form-data"},E),{display:"none"},y.body);D(e,function(c,e){p("input",{type:"hidden",name:e,value:c},null,m)});m.submit();v(m)}};"";return E});p(c,"Extensions/Data.js",[c["Core/Chart/Chart.js"],c["Core/Globals.js"],c["Core/HttpUtilities.js"],c["Core/Series/Point.js"],c["Core/Series/SeriesRegistry.js"],c["Core/Utilities.js"],c["Core/DefaultOptions.js"]],function(c,e,p,K,L,q,D){var v=
e.doc,y=p.ajax,m=L.seriesTypes,M=D.getOptions;p=q.addEvent;var z=q.defined,F=q.extend,N=q.fireEvent,H=q.isNumber,A=q.merge,O=q.objectEach,G=q.pick,P=q.splat;q=function(){function c(a,b,f){this.options=this.rawColumns=this.firstRowAsNames=this.chartOptions=this.chart=void 0;this.dateFormats={"YYYY/mm/dd":{regex:/^([0-9]{4})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{1,2})$/,parser:function(a){return a?Date.UTC(+a[1],a[2]-1,+a[3]):NaN}},"dd/mm/YYYY":{regex:/^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{4})$/,
parser:function(a){return a?Date.UTC(+a[3],a[2]-1,+a[1]):NaN},alternative:"mm/dd/YYYY"},"mm/dd/YYYY":{regex:/^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{4})$/,parser:function(a){return a?Date.UTC(+a[3],a[1]-1,+a[2]):NaN}},"dd/mm/YY":{regex:/^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{2})$/,parser:function(a){if(!a)return NaN;var b=+a[3];b=b>(new Date).getFullYear()-2E3?b+1900:b+2E3;return Date.UTC(b,a[2]-1,+a[1])},alternative:"mm/dd/YY"},"mm/dd/YY":{regex:/^([0-9]{1,2})[\-\/\.]([0-9]{1,2})[\-\/\.]([0-9]{2})$/,
parser:function(a){return a?Date.UTC(+a[3]+2E3,a[1]-1,+a[2]):NaN}}};this.init(a,b,f)}c.prototype.init=function(a,b,f){var d=a.decimalPoint;b&&(this.chartOptions=b);f&&(this.chart=f);"."!==d&&","!==d&&(d=void 0);this.options=a;this.columns=a.columns||this.rowsToColumns(a.rows)||[];this.firstRowAsNames=G(a.firstRowAsNames,this.firstRowAsNames,!0);this.decimalRegex=d&&new RegExp("^(-?[0-9]+)"+d+"([0-9]+)$");void 0!==this.liveDataTimeout&&clearTimeout(this.liveDataTimeout);this.rawColumns=[];if(this.columns.length){this.dataFound();
var n=!this.hasURLOption(a)}n||(n=this.fetchLiveData());n||(n=!!this.parseCSV().length);n||(n=!!this.parseTable().length);n||(n=this.parseGoogleSpreadsheet());!n&&a.afterComplete&&a.afterComplete()};c.prototype.hasURLOption=function(a){return!(!a||!(a.rowsURL||a.csvURL||a.columnsURL))};c.prototype.getColumnDistribution=function(){var a=this.chartOptions,b=this.options,f=[],d=function(a){return(m[a||"line"].prototype.pointArrayMap||[0]).length},n=a&&a.chart&&a.chart.type,h=[],c=[],g=0;b=b&&b.seriesMapping||
a&&a.series&&a.series.map(function(){return{x:0}})||[];var l;(a&&a.series||[]).forEach(function(a){h.push(d(a.type||n))});b.forEach(function(a){f.push(a.x||0)});0===f.length&&f.push(0);b.forEach(function(b){var f=new J,e=h[g]||d(n),B=(a&&a.series||[])[g]||{},t=m[B.type||n||"line"].prototype.pointArrayMap,u=t||["y"];(z(b.x)||B.isCartesian||!t)&&f.addColumnReader(b.x,"x");O(b,function(a,b){"x"!==b&&f.addColumnReader(a,b)});for(l=0;l<e;l++)f.hasReader(u[l])||f.addColumnReader(void 0,u[l]);c.push(f);
g++});b=m[n||"line"].prototype.pointArrayMap;"undefined"===typeof b&&(b=["y"]);this.valueCount={global:d(n),xColumns:f,individual:h,seriesBuilders:c,globalPointArrayMap:b}};c.prototype.dataFound=function(){this.options.switchRowsAndColumns&&(this.columns=this.rowsToColumns(this.columns));this.getColumnDistribution();this.parseTypes();!1!==this.parsed()&&this.complete()};c.prototype.parseCSV=function(a){function b(a,b,f,d){function c(b){k=a[b];g=a[b-1];B=a[b+1]}function h(a){w.length<x+1&&w.push([a]);
w[x][w[x].length-1]!==a&&w[x].push(a)}function n(){l>r||r>m?(++r,t=""):(!isNaN(parseFloat(t))&&isFinite(t)?(t=parseFloat(t),h("number")):isNaN(Date.parse(t))?h("string"):(t=t.replace(/\//g,"-"),h("date")),C.length<x+1&&C.push([]),f||(C[x][b]=t),t="",++x,++r)}var e=0,k="",g="",B="",t="",r=0,x=0;if(a.trim().length&&"#"!==a.trim()[0]){for(;e<a.length;e++)if(c(e),'"'===k)for(c(++e);e<a.length&&('"'!==k||'"'===g||'"'===B);){if('"'!==k||'"'===k&&'"'!==g)t+=k;c(++e)}else d&&d[k]?d[k](k,t)&&n():k===u?n():
t+=k;n()}}function f(a){var b=0,f=0,d=!1;a.some(function(a,d){var c=!1,h="";if(13<d)return!0;for(var n=0;n<a.length;n++){d=a[n];var k=a[n+1];var e=a[n-1];if("#"===d)break;if('"'===d)if(c){if('"'!==e&&'"'!==k){for(;" "===k&&n<a.length;)k=a[++n];"undefined"!==typeof r[k]&&r[k]++;c=!1}}else c=!0;else"undefined"!==typeof r[d]?(h=h.trim(),isNaN(Date.parse(h))?!isNaN(h)&&isFinite(h)||r[d]++:r[d]++,h=""):h+=d;","===d&&f++;"."===d&&b++}});d=r[";"]>r[","]?";":",";h.decimalPoint||(h.decimalPoint=b>f?".":",",
c.decimalRegex=new RegExp("^(-?[0-9]+)"+h.decimalPoint+"([0-9]+)$"));return d}function d(a,b){var d=[],f=0,n=!1,k=[],e=[],g;if(!b||b>a.length)b=a.length;for(;f<b;f++)if("undefined"!==typeof a[f]&&a[f]&&a[f].length){var l=a[f].trim().replace(/\//g," ").replace(/\-/g," ").replace(/\./g," ").split(" ");d=["","",""];for(g=0;g<l.length;g++)g<d.length&&(l[g]=parseInt(l[g],10),l[g]&&(e[g]=!e[g]||e[g]<l[g]?l[g]:e[g],"undefined"!==typeof k[g]?k[g]!==l[g]&&(k[g]=!1):k[g]=l[g],31<l[g]?d[g]=100>l[g]?"YY":"YYYY":
12<l[g]&&31>=l[g]?(d[g]="dd",n=!0):d[g].length||(d[g]="mm")))}if(n){for(g=0;g<k.length;g++)!1!==k[g]?12<e[g]&&"YY"!==d[g]&&"YYYY"!==d[g]&&(d[g]="YY"):12<e[g]&&"mm"===d[g]&&(d[g]="dd");3===d.length&&"dd"===d[1]&&"dd"===d[2]&&(d[2]="YY");a=d.join("/");return(h.dateFormats||c.dateFormats)[a]?a:(N("deduceDateFailed"),"YYYY/mm/dd")}return"YYYY/mm/dd"}var c=this,h=a||this.options,e=h.csv;a="undefined"!==typeof h.startRow&&h.startRow?h.startRow:0;var g=h.endRow||Number.MAX_VALUE,l="undefined"!==typeof h.startColumn&&
h.startColumn?h.startColumn:0,m=h.endColumn||Number.MAX_VALUE,k=0,w=[],r={",":0,";":0,"\t":0};var C=this.columns=[];e&&h.beforeParse&&(e=h.beforeParse.call(this,e));if(e){e=e.replace(/\r\n/g,"\n").replace(/\r/g,"\n").split(h.lineDelimiter||"\n");if(!a||0>a)a=0;if(!g||g>=e.length)g=e.length-1;if(h.itemDelimiter)var u=h.itemDelimiter;else u=null,u=f(e);var p=0;for(k=a;k<=g;k++)"#"===e[k][0]?p++:b(e[k],k-a-p);h.columnTypes&&0!==h.columnTypes.length||!w.length||!w[0].length||"date"!==w[0][1]||h.dateFormat||
(h.dateFormat=d(C[0]));this.dataFound()}return C};c.prototype.parseTable=function(){var a=this.options,b=a.table,f=this.columns||[],d=a.startRow||0,n=a.endRow||Number.MAX_VALUE,h=a.startColumn||0,c=a.endColumn||Number.MAX_VALUE;b&&("string"===typeof b&&(b=v.getElementById(b)),[].forEach.call(b.getElementsByTagName("tr"),function(a,b){b>=d&&b<=n&&[].forEach.call(a.children,function(a,g){var n=f[g-h],e=1;if(("TD"===a.tagName||"TH"===a.tagName)&&g>=h&&g<=c)for(f[g-h]||(f[g-h]=[]),f[g-h][b-d]=a.innerHTML;b-
d>=e&&void 0===n[b-d-e];)n[b-d-e]=null,e++})}),this.dataFound());return f};c.prototype.fetchLiveData=function(){function a(h){function l(g,l,m){function k(){c&&f.liveDataURL===g&&(b.liveDataTimeout=setTimeout(a,e))}if(!g||!/^(http|\/|\.\/|\.\.\/)/.test(g))return g&&d.error&&d.error("Invalid URL"),!1;h&&(clearTimeout(b.liveDataTimeout),f.liveDataURL=g);y({url:g,dataType:m||"json",success:function(a){f&&f.series&&l(a);k()},error:function(a,b){3>++n&&k();return d.error&&d.error(b,a)}});return!0}l(g.csvURL,
function(a){f.update({data:{csv:a}})},"text")||l(g.rowsURL,function(a){f.update({data:{rows:a}})})||l(g.columnsURL,function(a){f.update({data:{columns:a}})})}var b=this,f=this.chart,d=this.options,n=0,c=d.enablePolling,e=1E3*(d.dataRefreshRate||2),g=A(d);if(!this.hasURLOption(d))return!1;1E3>e&&(e=1E3);delete d.csvURL;delete d.rowsURL;delete d.columnsURL;a(!0);return this.hasURLOption(d)};c.prototype.parseGoogleSpreadsheet=function(){function a(g){var c=["https://sheets.googleapis.com/v4/spreadsheets",
d,"values",e(),"?alt=json&majorDimension=COLUMNS&valueRenderOption=UNFORMATTED_VALUE&dateTimeRenderOption=FORMATTED_STRING&key="+f.googleAPIKey].join("/");y({url:c,dataType:"json",success:function(d){g(d);f.enablePolling&&(b.liveDataTimeout=setTimeout(function(){a(g)},h))},error:function(a,b){return f.error&&f.error(b,a)}})}var b=this,f=this.options,d=f.googleSpreadsheetKey,c=this.chart,h=Math.max(1E3*(f.dataRefreshRate||2),4E3),e=function(){if(f.googleSpreadsheetRange)return f.googleSpreadsheetRange;
var a=("ABCDEFGHIJKLMNOPQRSTUVWXYZ".charAt(f.startColumn||0)||"A")+((f.startRow||0)+1),b="ABCDEFGHIJKLMNOPQRSTUVWXYZ".charAt(G(f.endColumn,-1))||"ZZ";z(f.endRow)&&(b+=f.endRow+1);return a+":"+b};d&&(delete f.googleSpreadsheetKey,a(function(a){a=a.values;if(!a||0===a.length)return!1;var d=a.reduce(function(a,b){return Math.max(a,b.length)},0);a.forEach(function(a){for(var b=0;b<d;b++)"undefined"===typeof a[b]&&(a[b]=null)});c&&c.series?c.update({data:{columns:a}}):(b.columns=a,b.dataFound())}));return!1};
c.prototype.trim=function(a,b){"string"===typeof a&&(a=a.replace(/^\s+|\s+$/g,""),b&&/^[0-9\s]+$/.test(a)&&(a=a.replace(/\s/g,"")),this.decimalRegex&&(a=a.replace(this.decimalRegex,"$1.$2")));return a};c.prototype.parseTypes=function(){for(var a=this.columns,b=a.length;b--;)this.parseColumn(a[b],b)};c.prototype.parseColumn=function(a,b){var f=this.rawColumns,d=this.columns,c=this.firstRowAsNames,h=-1!==this.valueCount.xColumns.indexOf(b),e=[],g=this.chartOptions,l=(this.options.columnTypes||[])[b];
g=h&&(g&&g.xAxis&&"category"===P(g.xAxis)[0].type||"string"===l);var m=z(a.name),k=a.length,p,r;for(f[b]||(f[b]=[]);k--;){var q=e[k]||a[k];var u=this.trim(q);var I=this.trim(q,!0);var v=parseFloat(I);"undefined"===typeof f[b][k]&&(f[b][k]=u);g||0===k&&c&&!m?a[k]=""+u:+I===v?(a[k]=v,31536E6<v&&"float"!==l?a.isDatetime=!0:a.isNumeric=!0,"undefined"!==typeof a[k+1]&&(r=v>a[k+1])):(u&&u.length&&(p=this.parseDate(q)),h&&H(p)&&"float"!==l?(e[k]=q,a[k]=p,a.isDatetime=!0,"undefined"!==typeof a[k+1]&&(q=p>
a[k+1],q!==r&&"undefined"!==typeof r&&(this.alternativeFormat?(this.dateFormat=this.alternativeFormat,k=a.length,this.alternativeFormat=this.dateFormats[this.dateFormat].alternative):a.unsorted=!0),r=q)):(a[k]=""===u?null:u,0!==k&&(a.isDatetime||a.isNumeric)&&(a.mixed=!0)))}h&&a.mixed&&(d[b]=f[b]);if(h&&r&&this.options.sort)for(b=0;b<d.length;b++)d[b].reverse(),c&&d[b].unshift(d[b].pop())};c.prototype.parseDate=function(a){var b=this.options.parseDate,f,d=this.options.dateFormat||this.dateFormat,
c;if(b)var h=b(a);else if("string"===typeof a){if(d)(b=this.dateFormats[d])||(b=this.dateFormats["YYYY/mm/dd"]),(c=a.match(b.regex))&&(h=b.parser(c));else for(f in this.dateFormats)if(b=this.dateFormats[f],c=a.match(b.regex)){this.dateFormat=f;this.alternativeFormat=b.alternative;h=b.parser(c);break}c||(a.match(/:.+(GMT|UTC|[Z+-])/)&&(a=a.replace(/\s*(?:GMT|UTC)?([+-])(\d\d)(\d\d)$/,"$1$2:$3").replace(/(?:\s+|GMT|UTC)([+-])/,"$1").replace(/(\d)\s*(?:GMT|UTC|Z)$/,"$1+00:00")),c=Date.parse(a),"object"===
typeof c&&null!==c&&c.getTime?h=c.getTime()-6E4*c.getTimezoneOffset():H(c)&&(h=c-6E4*(new Date(c)).getTimezoneOffset()))}return h};c.prototype.rowsToColumns=function(a){var b,f;if(a){var d=[];var c=a.length;for(b=0;b<c;b++){var h=a[b].length;for(f=0;f<h;f++)d[f]||(d[f]=[]),d[f][b]=a[b][f]}}return d};c.prototype.getData=function(){if(this.columns)return this.rowsToColumns(this.columns).slice(1)};c.prototype.parsed=function(){if(this.options.parsed)return this.options.parsed.call(this,this.columns)};
c.prototype.getFreeIndexes=function(a,b){var f,d=[],c=[];for(f=0;f<a;f+=1)d.push(!0);for(a=0;a<b.length;a+=1){var h=b[a].getReferencedColumnIndexes();for(f=0;f<h.length;f+=1)d[h[f]]=!1}for(f=0;f<d.length;f+=1)d[f]&&c.push(f);return c};c.prototype.complete=function(){var a=this.columns,b,c=this.options,d,e,h=[];if(c.complete||c.afterComplete){if(this.firstRowAsNames)for(d=0;d<a.length;d++){var m=a[d];z(m.name)||(m.name=G(m.shift(),"").toString())}m=[];var g=this.getFreeIndexes(a.length,this.valueCount.seriesBuilders);
for(d=0;d<this.valueCount.seriesBuilders.length;d++){var l=this.valueCount.seriesBuilders[d];l.populateColumns(g)&&h.push(l)}for(;0<g.length;){l=new J;l.addColumnReader(0,"x");d=g.indexOf(0);-1!==d&&g.splice(d,1);for(d=0;d<this.valueCount.global;d++)l.addColumnReader(void 0,this.valueCount.globalPointArrayMap[d]);l.populateColumns(g)&&h.push(l)}0<h.length&&0<h[0].readers.length&&(l=a[h[0].readers[0].columnIndex],"undefined"!==typeof l&&(l.isDatetime?b="datetime":l.isNumeric||(b="category")));if("category"===
b)for(d=0;d<h.length;d++)for(l=h[d],g=0;g<l.readers.length;g++)"x"===l.readers[g].configName&&(l.readers[g].configName="name");for(d=0;d<h.length;d++){l=h[d];g=[];for(e=0;e<a[0].length;e++)g[e]=l.read(a,e);m[d]={data:g};l.name&&(m[d].name=l.name);"category"===b&&(m[d].turboThreshold=0)}a={series:m};b&&(a.xAxis={type:b},"category"===b&&(a.xAxis.uniqueNames=!1));c.complete&&c.complete(a);c.afterComplete&&c.afterComplete(a)}};c.prototype.update=function(a,b){var c=this.chart,d=c.options;a&&(a.afterComplete=
function(a){a&&(a.xAxis&&c.xAxis[0]&&a.xAxis.type===c.xAxis[0].options.type&&delete a.xAxis,c.update(a,b,!0))},A(!0,d.data,a),d.data&&d.data.googleSpreadsheetKey&&!a.columns&&delete d.data.columns,this.init(d.data))};return c}();e.data=function(c,a,b){return new e.Data(c,a,b)};p(c,"init",function(c){var a=this,b=c.args[0]||{},f=c.args[1],d=M().data;(d||b&&b.data)&&!a.hasDataDef&&(a.hasDataDef=!0,d=A(d,b.data),a.data=new e.Data(F(d,{afterComplete:function(c){var d;if(Object.hasOwnProperty.call(b,"series"))if("object"===
typeof b.series)for(d=Math.max(b.series.length,c&&c.series?c.series.length:0);d--;){var e=b.series[d]||{};b.series[d]=A(e,c&&c.series?c.series[d]:{})}else delete b.series;b=A(c,b);a.init(b,f)}}),b,a),c.preventDefault())});var J=function(){function c(){this.readers=[];this.pointIsArray=!0;this.name=void 0}c.prototype.populateColumns=function(a){var b=!0;this.readers.forEach(function(b){"undefined"===typeof b.columnIndex&&(b.columnIndex=a.shift())});this.readers.forEach(function(a){"undefined"===typeof a.columnIndex&&
(b=!1)});return b};c.prototype.read=function(a,b){var c=this.pointIsArray,d=c?[]:{};this.readers.forEach(function(e){var f=a[e.columnIndex][b];c?d.push(f):0<e.configName.indexOf(".")?K.prototype.setNestedProperty(d,f,e.configName):d[e.configName]=f});if("undefined"===typeof this.name&&2<=this.readers.length){var e=this.getReferencedColumnIndexes();2<=e.length&&(e.shift(),e.sort(function(a,b){return a-b}),this.name=a[e.shift()].name)}return d};c.prototype.addColumnReader=function(a,b){this.readers.push({columnIndex:a,
configName:b});"x"!==b&&"y"!==b&&"undefined"!==typeof b&&(this.pointIsArray=!1)};c.prototype.getReferencedColumnIndexes=function(){var a,b=[];for(a=0;a<this.readers.length;a+=1){var c=this.readers[a];"undefined"!==typeof c.columnIndex&&b.push(c.columnIndex)}return b};c.prototype.hasReader=function(a){var b;for(b=0;b<this.readers.length;b+=1){var c=this.readers[b];if(c.configName===a)return!0}};return c}();e.Data=q;return e.Data});p(c,"masters/modules/data.src.js",[c["Core/Globals.js"],c["Core/HttpUtilities.js"],
c["Extensions/Data.js"]],function(c,e,p){c.ajax=e.ajax;c.getJSON=e.getJSON;c.post=e.post;c.Data=p;c.HttpUtilities=e})});
//# sourceMappingURL=data.js.map