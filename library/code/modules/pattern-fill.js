/*
 Highcharts JS v10.0.0 (2022-03-07)

 Module for adding patterns and images as point fills.

 (c) 2010-2021 Highsoft AS
 Author: Torstein Hnsi, ystein Moseng

 License: www.jabarsoft.com/license
*/
(function(b){"object"===typeof module&&module.exports?(b["default"]=b,module.exports=b):"function"===typeof define&&define.amd?define("highcharts/modules/pattern-fill",["highcharts"],function(f){b(f);b.Highcharts=f;return b}):b("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(b){function f(b,g,f,p){b.hasOwnProperty(g)||(b[g]=p.apply(null,f),"function"===typeof CustomEvent&&window.dispatchEvent(new CustomEvent("HighchartsModuleLoaded",{detail:{path:g,module:b[g]}})))}b=b?b._modules:{};
f(b,"Extensions/PatternFill.js",[b["Core/Animation/AnimationUtilities.js"],b["Core/Chart/Chart.js"],b["Core/Globals.js"],b["Core/DefaultOptions.js"],b["Core/Series/Point.js"],b["Core/Series/Series.js"],b["Core/Renderer/SVG/SVGRenderer.js"],b["Core/Utilities.js"]],function(b,f,x,p,r,t,u,m){function g(a,c){a=JSON.stringify(a);var b=a.length||0,e=0,d=0;if(c){c=Math.max(Math.floor(b/500),1);for(var n=0;n<b;n+=c)e+=a.charCodeAt(n);e&=e}for(;d<b;++d)c=a.charCodeAt(d),e=(e<<5)-e+c,e&=e;return e.toString(16).replace("-",
"1")}var y=b.animObject,z=p.getOptions;b=m.addEvent;var A=m.erase,v=m.merge,q=m.pick,B=m.removeEvent;p=m.wrap;var w=x.patterns=function(){var a=[],c=z().colors;["M 0 0 L 5 5 M 4.5 -0.5 L 5.5 0.5 M -0.5 4.5 L 0.5 5.5","M 0 5 L 5 0 M -0.5 0.5 L 0.5 -0.5 M 4.5 5.5 L 5.5 4.5","M 2 0 L 2 5 M 4 0 L 4 5","M 0 2 L 5 2 M 0 4 L 5 4","M 0 1.5 L 2.5 1.5 L 2.5 0 M 2.5 5 L 2.5 3.5 L 5 3.5"].forEach(function(b,e){a.push({path:b,color:c[e],width:5,height:5,patternTransform:"scale(1.4 1.4)"})});["M 0 0 L 5 10 L 10 0",
"M 3 3 L 8 3 L 8 8 L 3 8 Z","M 5 5 m -4 0 a 4 4 0 1 1 8 0 a 4 4 0 1 1 -8 0","M 0 0 L 10 10 M 9 -1 L 11 1 M -1 9 L 1 11","M 0 10 L 10 0 M -1 1 L 1 -1 M 9 11 L 11 9"].forEach(function(b,e){a.push({path:b,color:c[e+5],width:10,height:10})});return a}();r.prototype.calculatePatternDimensions=function(a){if(!a.width||!a.height){var c=this.graphic&&(this.graphic.getBBox&&this.graphic.getBBox(!0)||this.graphic.element&&this.graphic.element.getBBox())||{},b=this.shapeArgs;b&&(c.width=b.width||c.width,c.height=
b.height||c.height,c.x=b.x||c.x,c.y=b.y||c.y);if(a.image){if(!c.width||!c.height){a._width="defer";a._height="defer";return}a.aspectRatio&&(c.aspectRatio=c.width/c.height,a.aspectRatio>c.aspectRatio?c.aspectWidth=c.height*a.aspectRatio:c.aspectHeight=c.width/a.aspectRatio);a._width=a.width||Math.ceil(c.aspectWidth||c.width);a._height=a.height||Math.ceil(c.aspectHeight||c.height)}a.width||(a._x=a.x||0,a._x+=c.x-Math.round(c.aspectWidth?Math.abs(c.aspectWidth-c.width)/2:0));a.height||(a._y=a.y||0,a._y+=
c.y-Math.round(c.aspectHeight?Math.abs(c.aspectHeight-c.height)/2:0))}};u.prototype.addPattern=function(a,c){c=q(c,!0);var b=y(c),e=a.width||a._width||32,d=a.height||a._height||32,n=a.color||"#343434",h=a.id,f=this,g=function(a){f.rect(0,0,e,d).attr({fill:a}).add(l)};h||(this.idCounter=this.idCounter||0,h="highcharts-pattern-"+this.idCounter+"-"+(this.chartIndex||0),++this.idCounter);this.forExport&&(h+="-export");this.defIds=this.defIds||[];if(!(-1<this.defIds.indexOf(h))){this.defIds.push(h);var k=
{id:h,patternUnits:"userSpaceOnUse",patternContentUnits:a.patternContentUnits||"userSpaceOnUse",width:e,height:d,x:a._x||a.x||0,y:a._y||a.y||0};a.patternTransform&&(k.patternTransform=a.patternTransform);var l=this.createElement("pattern").attr(k).add(this.defs);l.id=h;a.path?(k=m.isObject(a.path)?a.path:{d:a.path},a.backgroundColor&&g(a.backgroundColor),g={d:k.d},this.styledMode||(g.stroke=k.stroke||n,g["stroke-width"]=q(k.strokeWidth,2),g.fill=k.fill||"none"),k.transform&&(g.transform=k.transform),
this.createElement("path").attr(g).add(l),l.color=n):a.image&&(c?this.image(a.image,0,0,e,d,function(){this.animate({opacity:q(a.opacity,1)},b);B(this.element,"load")}).attr({opacity:0}).add(l):this.image(a.image,0,0,e,d).add(l));a.image&&c||"undefined"===typeof a.opacity||[].forEach.call(l.element.childNodes,function(c){c.setAttribute("opacity",a.opacity)});this.patternElements=this.patternElements||{};return this.patternElements[h]=l}};p(t.prototype,"getColor",function(a){var c=this.options.color;
c&&c.pattern&&!c.pattern.color?(delete this.options.color,a.apply(this,Array.prototype.slice.call(arguments,1)),c.pattern.color=this.color,this.color=this.options.color=c):a.apply(this,Array.prototype.slice.call(arguments,1))});b(t,"render",function(){var a=this.chart.isResizing;(this.isDirtyData||a||!this.chart.hasRendered)&&(this.points||[]).forEach(function(c){var b=c.options&&c.options.color;b&&b.pattern&&(!a||c.shapeArgs&&c.shapeArgs.width&&c.shapeArgs.height?c.calculatePatternDimensions(b.pattern):
(b.pattern._width="defer",b.pattern._height="defer"))})});b(r,"afterInit",function(){var a=this.options.color;a&&a.pattern&&("string"===typeof a.pattern.path&&(a.pattern.path={d:a.pattern.path}),this.color=this.options.color=v(this.series.options.color,a))});b(u,"complexColor",function(a){var c=a.args[0],b=a.args[1];a=a.args[2];var e=this.chartIndex||0,d=c.pattern,f="#343434";"undefined"!==typeof c.patternIndex&&w&&(d=w[c.patternIndex]);if(!d)return!0;if(d.image||"string"===typeof d.path||d.path&&
d.path.d){var h=a.parentNode&&a.parentNode.getAttribute("class");h=h&&-1<h.indexOf("highcharts-legend");"defer"!==d._width&&"defer"!==d._height||r.prototype.calculatePatternDimensions.call({graphic:{element:a}},d);if(h||!d.id)d=v({},d),d.id="highcharts-pattern-"+e+"-"+g(d)+g(d,!0);this.addPattern(d,!this.forExport&&q(d.animation,this.globalAnimation,{duration:100}));f="url("+this.url+"#"+(d.id+(this.forExport?"-export":""))+")"}else f=d.color||f;a.setAttribute(b,f);c.toString=function(){return f};
return!1});b(f,"endResize",function(){(this.renderer&&this.renderer.defIds||[]).filter(function(a){return a&&a.indexOf&&0===a.indexOf("highcharts-pattern-")}).length&&(this.series.forEach(function(a){a.points.forEach(function(a){(a=a.options&&a.options.color)&&a.pattern&&(a.pattern._width="defer",a.pattern._height="defer")})}),this.redraw(!1))});b(f,"redraw",function(){var a={},c=this.renderer,b=(c.defIds||[]).filter(function(a){return a.indexOf&&0===a.indexOf("highcharts-pattern-")});b.length&&([].forEach.call(this.renderTo.querySelectorAll('[color^="url("], [fill^="url("], [stroke^="url("]'),
function(b){if(b=b.getAttribute("fill")||b.getAttribute("color")||b.getAttribute("stroke"))b=b.replace(c.url,"").replace("url(#","").replace(")",""),a[b]=!0}),b.forEach(function(b){a[b]||(A(c.defIds,b),c.patternElements[b]&&(c.patternElements[b].destroy(),delete c.patternElements[b]))}))});""});f(b,"masters/modules/pattern-fill.src.js",[],function(){})});
//# sourceMappingURL=pattern-fill.js.map