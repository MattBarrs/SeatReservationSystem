
<template>
    <div>
        <vue-slider v-model="radius"/>

        X:{{x}},Y:{{y}}
        <canvas id="canvas"  height="600"width="800" @mousemove="showCoordinates" @mousedown="drawCircle" style="border: 1px solid grey;">
        Your browser does not support HTML5 canvas tag
        </canvas>
    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'

    export default{
        components:{
            VueSlider
        },

        mounted(){
            var c = document.getElementById("canvas");
            const contextCanvas = c.getContext('2d');

            const img = new Image();
            img.src = "./img/default_floorplan.jpg"
            img.onload = () =>{
                contextCanvas.drawImage(img,0,0,900,700)
            }
        },

        data: function () {
            return{
                x:10,
                y:11,
                radius:10
                }
            },
        methods:{
                showCoordinates(e){
                    this.x = e.offsetX;
                    this.y = e.offsetY;
                },
                drawCircle(e){
                    var c = document.getElementById("canvas");
                    var ctx = c.getContext("2d");
                    ctx.beginPath();
                    ctx.arc( e.offsetX,  e.offsetY, this.radius, 0, 2 * Math.PI);
                    ctx.stroke();
                }
            }

    }
</script>


<style scoped>
    p {
    font-size: 2em;
    text-align: center;
    }
</style>
