<template>
    <div>

        <b-sidebar  id="accessibility-sidebar" title="Accessibilty" right shadow>
                <button id="resetColours" class="clickable" style="margin-bottom:10px;">Reset Colours</button>

                <div class="accordion" role="tablist">
                    <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block v-b-toggle.accordion-4 variant="info">Colour Options 01</b-button>

                </b-card-header>
                <b-collapse visible id="accordion-4" accordion="colour-accordion" role="tabpanel">
                <b-card-body>
                <b-card-text>

                <div class="inline-block">
                <div class='sampleBox darkGreen'/>
                    &nbsp;Selected
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox blue'/>
                    &nbsp;Available
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox yellow'/>
                    &nbsp;Not Available
                </div>
                <br/>

                <button id="alterColour_01" class="clickable">Activate</button>

                    </b-card-text>
                    </b-card-body>
                    </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block v-b-toggle.accordion-5 variant="info">Colour Options 02</b-button>
                </b-card-header>
                <b-collapse id="accordion-5" accordion="colour-accordion" role="tabpanel">
                <b-card-body>
                <b-card-text>

                <div class="inline-block">
                <div class='sampleBox darkGrey'/>
                    &nbsp;Selected
                </div>
                <br/>
                <div class="inline-block">

                <div class='sampleBox blue2'/>
                    &nbsp;Available
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox yellow2'/>
                    &nbsp;Not Available
                </div>
                <br/>

                <button id="alterColour_02" class="clickable">Activate</button>
                    </b-card-text>
                    </b-card-body>
                    </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block v-b-toggle.accordion-6 variant="info">Colour Options 03</b-button>
                </b-card-header>

                <b-collapse id="accordion-6" accordion="colour-accordion" role="tabpanel">
                <b-card-body>
                <b-card-text>

                <div class="inline-block">
                <div class='sampleBox darkBrown'/>
                    &nbsp;Selected
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox yellow3'/>
                    &nbsp;Available
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox pink'/>
                    &nbsp;Not Available
                </div>
                <br/>

                <button id="alterColour_03" class="clickable">Activate</button>
                    </b-card-text>
                    </b-card-body>
                    </b-collapse>
                    </b-card>
                    </div>
        </b-collapse>



                </b-collapse>

        </b-sidebar>

        <b-button v-b-toggle.collapse-1 id="loadcanvas" variant="primary" class="clickable" style="margin-left:10px;" placeholder="time_end" ref="showCanvas">View Room</b-button>
        <b-collapse id="collapse-1" class="mt-2">
            <b-card>
                <b-button v-b-toggle href="#accessibility-sidebar" @click.prevent class="clickable">Accessibilty</b-button>
                <br/>
                <br/>
                <canvas ref="can" width="750" height="750"  style="border: 1px solid grey;"></canvas>
            </b-card>
        </b-collapse>

<br/>


</div>
</template>

<script>
    import { fabric } from 'fabric';



    import { VBToggle } from 'bootstrap-vue'
     Vue.directive('b-toggle', VBToggle)

    import { VBTogglePlugin } from 'bootstrap-vue'
    Vue.use(VBTogglePlugin)


export default {


        components: {
            // VueTimepicker,
            // Datepicker,
        },


        props:['input_roomcanvas'],

        data() {
            return{
                // isChanged: true,
            }
        },

        methods:{
            checkAvailable(eventData)
            {
                if( !(eventData['displayTime'].includes("H")) && !(eventData['displayTime'].includes("h")) && !(eventData['displayTime'].includes("m") ) &&  eventData['displayTime'] != ""  ){
                    var timeInterval = 59;

                    var temp_split = eventData['displayTime'].split(":");

                    var temp_hh, temp_mm;
                    temp_split[0] = parseInt(temp_split[0]);
                    temp_split[1] = parseInt(temp_split[1]);

                    if( temp_split[1] + timeInterval > 60)
                    {
                        // console.log("IF");
                        temp_mm = temp_split[1] + timeInterval;
                        var remainder = temp_mm % 60;
                        var divisions = (temp_mm - remainder)/60;

                        temp_hh = temp_split[0] + divisions;
                        temp_mm = remainder;
                        if(temp_hh>=24) temp_hh= temp_hh%24;

                    }
                    else{
                        temp_hh = parseInt(temp_split[0]);
                        temp_mm = parseInt(temp_split[1]) + timeInterval;
                    }

                    this.time_end['hh'] = temp_hh;
                    this.time_end['mm'] = temp_mm;

                    var endTime = temp_hh + ":"+ temp_mm;

                    document.getElementById("time_end").placeholder = endTime;

                }
            },
        },

        mounted: function(){


            //Define + create canvas
            const ref = this.$refs.can;
            const canvas = new fabric.Canvas(ref);


            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            var height = (window.innerHeight > 0) ? window.innerHeight : screen.height;
            width = width*0.6;
            height = height*0.6;
            if(width>1000) width=1000;

            canvas.setWidth(width);
            canvas.setHeight(height);

            var $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;
            fabric.Group.prototype.hasControls = false
            fabric.Group.prototype.lockMovementX = true;
            fabric.Group.prototype.lockMovementY = true;



            // // Define variables
            let seatSelected = '#808080';
            let seatAvailable = '#baf312';
            let seatNotAvailable = '#ff0000';
            let previousColourState = [];

            if(this.input_roomcanvas != ""){
                canvas.loadFromJSON(this.input_roomcanvas, canvas.renderAll.bind(canvas));
                canvas.requestRenderAll();

            }

            loadcanvas.onclick = function() {
                canvas.forEachObject(function(object) {
                    if( object.get('type') == "rect") object.visible = false;
                    if( object.get('type') == "line") object.visible = false;

                    object.hasControls = false;
                    object.lockMovementX = true;
                    object.lockMovementY = true;

                    if( object.get('type') == "group") previousColourState.push(object.item(0).get('fill'));

                    canvas.requestRenderAll();
                });
                changeColours('#808080','#baf312','#ff0000');

            }

            alterColour_01.onclick = function() { changeColours("#48453E","#1E88E5", "#FFC107");}

            alterColour_02.onclick = function() { changeColours("#48453E", "#40B0A6","#E1BE6A");}

            alterColour_03.onclick = function() { changeColours("#994F00", "#FEFE62", "#D35FB7" );}

            resetColours.onclick = function() { changeColours('#808080','#baf312','#ff0000');}


            function changeColours(colour1,colour2,colour3){
                canvas.discardActiveObject();

                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    var index = object.get('name');

                    if(object.item(0).get('fill') == seatAvailable){
                        previousColourState[index] = colour2;
                        object.item(0).set('fill' ,colour2);
                    }
                    else if(object.item(0).get('fill') == seatNotAvailable) {
                        previousColourState[index] = colour3;
                        object.item(0).set('fill' ,colour3);
                    }

                });

                seatSelected = colour1;
                seatAvailable = colour2;
                seatNotAvailable = colour3;

                canvas.requestRenderAll();
            }

            canvas.on('mouse:wheel', function(opt) {
                var delta = opt.e.deltaY;

                var zoom = canvas.getZoom();
                zoom *= 0.999 ** delta;
                if (zoom > 8 ) zoom = 8;
                if (zoom < 0.25) zoom = 0.25;

                canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
                opt.e.preventDefault();
                opt.e.stopPropagation();
            });



            canvas.on('mouse:down', function(opt) {
                var evt = opt.e;
                this.isDragging = true;
                this.selection = false;
                this.lastPosX = evt.clientX;
                this.lastPosY = evt.clientY;
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
                this.setViewportTransform(this.viewportTransform);
                this.isDragging = false;
                this.selection = true;
            });

            canvas.on('selection:created', (e) => {
                // console.log(previousColourState);

                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    var index = object.get('name');
                    var colour = previousColourState[index];

                    // console.log(colour);
                    // console.log("NAME:", index);

                    object.item(0).set('fill',colour);
                });


                if(e.target.type === 'activeSelection') {
                    canvas.discardActiveObject();
                } else {
                    e.target.item(0).set('fill',seatSelected);
                }
            })

            canvas.on('selection:updated', (e) => {
                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    var index = object.get('name');
                    var colour = previousColourState[index];

                    object.item(0).set('fill',colour);
                });

                if(e.target.type === 'activeSelection') {
                    canvas.discardActiveObject();
                } else {
                    e.target.item(0).set('fill',seatSelected);
                }
            })
            canvas.on('selection:cleared', function() {
                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    var index = object.get('name');
                    var colour = previousColourState[index];

                    object.item(0).set('fill',colour);
                });
            });

        },
    };
</script>
