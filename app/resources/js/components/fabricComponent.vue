<template>
    <div>
        Num of Seats: {{seatCounter}}
        // //<vue-slider id="scaleControl" v-model="scaleControl"/>
        <input type="range" id="scale-control" value="1" min="0.1" max="3" step="0.1">
        <canvas ref="can" width="900" height="500"  style="border: 1px solid grey;" @mousedown="drawRectangle"></canvas>
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
            // Define the URL where your background image is located
            var imageUrl = "./img/default_floorplan.jpg";

            // // Define
            // canvas.setBackgroundImage(imageUrl, canvas.renderAll.bind(canvas), {
            //     // Optionally add an opacity lvl to the image
            //     backgroundImageOpacity: 1,
            //     // should the image be resized to fit the container?
            //     backgroundImageStretch: true,
            //     height: 600,
            //     width: 800,
            // });
            fabric.Image.fromURL(imageUrl, function(img){
                img.scaleToHeight(canvas.height);
                img.scaleToWidth(canvas.width);
                canvas.setBackgroundImage(img);
                canvas.requestRenderAll();
            });


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


            var $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;

            var seatCounter =0;
            addmore.onclick = function() {
                var red = new fabric.Rect({
                    top: 100, left: 0, width: 50, height: 50, fill: 'blue' });
                canvas.add(red);
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

            var scaleControl = $('scale-control');
            scaleControl.oninput = function() {
                rect.scale(parseFloat(this.value)).setCoords();
                canvas.requestRenderAll();
            };


            function updateControls() {
                scaleControl.value = rect.scaleX;
            }
            canvas.on({
                'object:scaling': updateControls,
            });


        },
        data: function () {
            return{
                seatCounter: 0,
            }
        },

};
</script>
