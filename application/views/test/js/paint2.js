function load(){
  prepareSimpleCanvas();
}


var canvasWidth = 490;
var canvasHeight = 220;


var clickX_simple = new Array();
var clickY_simple = new Array();
var clickDrag_simple = new Array();
var paint_simple;
var canvas_simple;
var context_simple;

function prepareSimpleCanvas()
{

	var canvasDiv = document.getElementById('canvasSimpleDiv');
	canvas_simple = document.createElement('canvas');
	canvas_simple.setAttribute('width', canvasWidth);
	canvas_simple.setAttribute('height', canvasHeight);
	canvas_simple.setAttribute('id', 'canvasSimple');
	canvasDiv.appendChild(canvas_simple);
	if(typeof G_vmlCanvasManager != 'undefined') {
		canvas_simple = G_vmlCanvasManager.initElement(canvas_simple);
	}
	context_simple = canvas_simple.getContext("2d");
  
  
	$('#canvasSimple').mousedown(function(e)
	{
    var offsets = document.getElementById('canvasSimple').getBoundingClientRect();
    var left = offsets.left;
    var top = offsets.top;

		var mouseX = e.pageX - left;
		var mouseY = e.pageY - top;
		
		paint_simple = true;
		addClickSimple(mouseX, mouseY, false);
		redrawSimple();
	});
	
	$('#canvasSimple').mousemove(function(e){
		if(paint_simple){

      var offsets = document.getElementById('canvasSimple').getBoundingClientRect();
      var left = offsets.left;
      var top = offsets.top;
      

			addClickSimple(e.pageX - left, e.pageY - top, true);
			redrawSimple();
		}
	});
	
	$('#canvasSimple').mouseup(function(e){
		paint_simple = false;
	  	redrawSimple();
	});
	
	$('#canvasSimple').mouseleave(function(e){
		paint_simple = false;
	});
	
	$('#clearCanvasSimple').mousedown(function(e)
	{
		clickX_simple = new Array();
		clickY_simple = new Array();
		clickDrag_simple = new Array();
		clearCanvas_simple(); 
	});
	
	canvas_simple.addEventListener("touchstart", function(e)
	{
    var offsets = document.getElementById('canvasSimple').getBoundingClientRect();
    var left = offsets.left;
    var top = offsets.top;

		var mouseX = (e.changedTouches ? e.changedTouches[0].pageX : e.pageX) - left,
			mouseY = (e.changedTouches ? e.changedTouches[0].pageY : e.pageY) - top;
		
		paint_simple = true;
		addClickSimple(mouseX, mouseY, false);
		redrawSimple();
	}, false);
	canvas_simple.addEventListener("touchmove", function(e){
    
    var offsets = document.getElementById('canvasSimple').getBoundingClientRect();
    var left = offsets.left;
    var top = offsets.top;

		var mouseX = (e.changedTouches ? e.changedTouches[0].pageX : e.pageX) - left,
			mouseY = (e.changedTouches ? e.changedTouches[0].pageY : e.pageY) - top;
					
		if(paint_simple){
			addClickSimple(mouseX, mouseY, true);
			redrawSimple();
		}
		e.preventDefault()
	}, false);
	canvas_simple.addEventListener("touchend", function(e){
		paint_simple = false;
	  	redrawSimple();
	}, false);
	canvas_simple.addEventListener("touchcancel", function(e){
		paint_simple = false;
	}, false);
}

function addClickSimple(x, y, dragging)
{
	clickX_simple.push(x);
	clickY_simple.push(y);
	clickDrag_simple.push(dragging);
}

function clearCanvas_simple()
{
	context_simple.clearRect(0, 0, canvasWidth, canvasHeight);
}

function redrawSimple()
{
	clearCanvas_simple();
	
	var radius = 5;
	context_simple.strokeStyle = "#df4b26";
	context_simple.lineJoin = "round";
	context_simple.lineWidth = radius;
			
	for(var i=0; i < clickX_simple.length; i++)
	{		
		context_simple.beginPath();
		if(clickDrag_simple[i] && i){
			context_simple.moveTo(clickX_simple[i-1], clickY_simple[i-1]);
		}else{
			context_simple.moveTo(clickX_simple[i]-1, clickY_simple[i]);
		}
		context_simple.lineTo(clickX_simple[i], clickY_simple[i]);
		context_simple.closePath();
		context_simple.stroke();
	}
}







function download_img(){
    var canvas = document.getElementById("myCanvas");
    var ctx = canvas.getContext("2d");
    var ox = canvas.width / 2;
    var oy = canvas.height / 2;
 

    download_img = function(el) {
    var image = canvas.toDataURL("image/jpg");
    el.href = image;
    };
}