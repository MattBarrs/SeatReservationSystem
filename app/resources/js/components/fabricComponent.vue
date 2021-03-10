<template>
    <div>
        Instructions:<br/>
            - 'ALT' + 'Left Click': Move view of canvas<br/>
            - 'Mouse wheel': Changes level of zoom<br/>
            - 'Alter Slider': Changes size of rectangles<br/>



        <button id="alterColour_01" class="clickable">Change Colours</button>
        <button id="alterColour_02" class="clickable">Change Colours</button>

<br/>Size of seats: <input type="range" id="scale-control" value="1" min="0.1" max="3" step="0.1">

        <canvas ref="can" width="900" height="900"  style="border: 1px solid grey;"></canvas>
        <button id="addmore" class="clickable">Add more Seats</button>
        <button id="group" class="clickable">Group Selection</button>
        <button id="ungroup" class="clickable">Ungroup Selection</button>
        <button id="discard" class="clickable">Discard Selection</button>


<br/>
        <button id="deleteSelection" class="redButton">Delete Selection</button>


</div>
</template>

<script>
    import { fabric } from 'fabric';
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'
    export default {
        components: {
            VueSlider
        },
        mounted() {



            const ref = this.$refs.can;
            const canvas = new fabric.Canvas(ref);

            canvas.setBackgroundImage('../img/default_floorplan.jpg', canvas.renderAll.bind(canvas));
            var $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;

            // // Define
            // canvas.setBackgroundImage(imageUrl, canvas.renderAll.bind(canvas), {
            //     // Optionally add an opacity lvl to the image
            //     backgroundImageOpacity: 1,
            //     // should the image be resized to fit the container?
            //     backgroundImageStretch: true,
            //     height: 600,
            //     width: 800,
            // });
            // fabric.Image.fromURL(imageUrl, function(img){
            //     img.scaleToHeight(canvas.height);
            //     img.scaleToWidth(canvas.width);
            //     canvas.setBackgroundImage(img);
            //     canvas.requestRenderAll();
            // });


            //////////Draw Shapes
            var circle = new fabric.Circle({
                radius: 50, left: 275, top: 75, fill: '#aac'
            });
            // var rect = new fabric.Rect({
            //     width: 100,
            //     height: 100,
            //     top: 100,
            //     left: 100,
            //     fill: 'rgba(0,0,255,1)'
            // });
            // canvas.add(rect);
            // rect.hasControls = false;
            canvas.add(circle);
            circle.hasControls = false;


            var circle2 = new fabric.Circle({
                radius: 50, left: 275, top: 75, fill: '#aac'
            });
            canvas.add(circle2);
            circle2.hasControls = false;

            // var rect1 = new fabric.Rect({
            //     width: 100,
            //     height: 100,
            //     top: 100,
            //     left: 100,
            //     fill: 'rgba(0,0,255,1)'
            // });
            // const rect = new fabric.Rect({
            //     fill: 'red',
            //     width: 20,
            //     height: 20
            // });
            // canvas.add(rect);
            // rect.animate('left', '+=100', { onChange: canvas.renderAll.bind(canvas) });
            // var circle = new fabric.Circle({
            //     radius: 20, fill: 'green', left: 100, top: 100
            // });
            // var triangle = new fabric.Triangle({
            //     width: 20, height: 30, fill: 'blue', left: 50, top: 50
            // });
            //
            // canvas.add(circle, triangle);
            // canvas.add(rect1);
            // rect1.hasControls = false;

            var seatCounter = 2;
            var seatColour = '#aac';
            var seatColour_clash = '#ff0000';

            var scaleControl = $('scale-control');
            scaleControl.oninput = function(options) {
                var objects = canvas.getObjects();
                for (var i in objects) {
                    objects[i].scaleX = this.value;
                    objects[i].scaleY = this.value;

                    // options.target.setCoords();
                    // canvas.forEachObject(function(obj) {
                    //     if (obj === options.target) return;
                    //     obj.set('fill' ,options.target.intersectsWithObject(obj) ? '#ff0000' : '#aac');
                    // });
                }
                canvas.requestRenderAll();
            };


            addmore.onclick = function() {
                var seat = new fabric.Circle({
                    radius: 50, left: 275, top: 75, fill: '#aac'
                });
                canvas.add(seat);
                seat.hasControls = false;

                seatCounter = seatCounter + 1;
            }

            group.onclick = function() {
                if (!canvas.getActiveObject()) {
                    return;
                }
                if (canvas.getActiveObject().type !== 'activeSelection') {
                    return;
                }
                canvas.getActiveObject().toGroup();
                canvas.requestRenderAll();
            }

            ungroup.onclick = function() {
                if (!canvas.getActiveObject()) {
                    return;
                }
                if (canvas.getActiveObject().type !== 'group') {
                    return;
                }
                canvas.getActiveObject().toActiveSelection();
                canvas.requestRenderAll();
            }

            deleteSelection.onclick = function() {
                canvas.remove( canvas.getActiveObject()) ;
                if(seatCounter != 0)
                {
                    seatCounter = seatCounter - 1;
                }
            }

            discard.onclick = function() {
                canvas.discardActiveObject();
                canvas.requestRenderAll();
            }

            alterColour_01.onclick = function() {
                canvas.forEachObject(function(obj) {
                    obj.set('fill' ,'#1E88E5');
                });
                seatColour = "#1E88E5";
                seatColour_clash = "#FFC107";
                canvas.requestRenderAll();

            }
            alterColour_02.onclick = function() {
                canvas.forEachObject(function(obj) {
                    obj.set('fill' ,'#40B0A6');
                });
                seatColour = "#40B0A6";
                seatColour_clash = "#E1BE6A";
                canvas.requestRenderAll();

            }

            function updateControls() {
                // scaleControl.value = rect.scaleX;
            }



            canvas.on('mouse:wheel', function(opt) {
                var delta = opt.e.deltaY;
                var zoom = canvas.getZoom();
                zoom *= 0.999 ** delta;
                if (zoom > 20) zoom = 20;
                if (zoom < 0.5) zoom = 0.5;
                canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
                opt.e.preventDefault();
                opt.e.stopPropagation();
            });
            canvas.on('mouse:down', function(opt) {
                var evt = opt.e;
                if (evt.altKey === true) {
                    this.isDragging = true;
                    this.selection = false;
                    this.lastPosX = evt.clientX;
                    this.lastPosY = evt.clientY;
                }
            });
            canvas.on('mouse:move', function(opt) {
                if (this.isDragging) {
                    var e = opt.e;
                    var vpt = this.viewportTransform;
                    vpt[4] += e.clientX - this.lastPosX;
                    vpt[5] += e.clientY - this.lastPosY;
                    this.requestRenderAll();
                    this.lastPosX = e.clientX;
                    this.lastPosY = e.clientY;
                }
            });
            canvas.on('mouse:up', function(opt) {
                // on mouse up we want to recalculate new interaction
                // for all objects, so we call setViewportTransform
                this.setViewportTransform(this.viewportTransform);
                this.isDragging = false;
                this.selection = true;
            });

            function onChange(options) {
                options.target.setCoords();

                canvas.forEachObject(function(obj) {
                    if (obj === options.target) return;
                    obj.set('fill' ,options.target.intersectsWithObject(obj) ? seatColour_clash : seatColour);
                });
            }

            canvas.on({
                'object:scaling': updateControls,
                'object:moving': onChange,

            });


        },
        data: function () {
            return{
                seatCounter: 0,
            }
        },

};
</script>
