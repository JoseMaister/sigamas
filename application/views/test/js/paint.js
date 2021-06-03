function load(){
    var canvas = document.getElementById('myCanvas');
    var ctx = canvas.getContext('2d');
    
    var painting = document.getElementById('paint');
    var paint_style = getComputedStyle(painting);
    canvas.width = parseInt(paint_style.getPropertyValue('width'));
    canvas.height = parseInt(paint_style.getPropertyValue('height'));

    var mouse = {x: 0, y: 0};
    
    canvas.addEventListener('mousemove', function(e) 
    {
        var offsets = document.getElementById('myCanvas').getBoundingClientRect();
        var top = offsets.top;
        var left = offsets.left;
        
        mouse.x = e.pageX - left;
        mouse.y = e.pageY - top;
        

        $('#divMonitor').text('X: ' + mouse.x + ' Y: ' + mouse.y + '       ' + 'offsetLeft: ' + this.offsetLeft + ' offsetTop: ' + this.offsetTop);

    }, false);

    ctx.lineWidth = 2;
    ctx.lineJoin = 'round';
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    
    canvas.addEventListener('mousedown', function(e) {
        ctx.beginPath();
        ctx.moveTo(mouse.x, mouse.y);
    
        canvas.addEventListener('mousemove', onPaint, false);
    }, false);
    
    canvas.addEventListener('mouseup', function() {
        canvas.removeEventListener('mousemove', onPaint, false);
    }, false);
    
    var onPaint = function() {
        ctx.lineTo(mouse.x, mouse.y);
        ctx.stroke();
    };
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