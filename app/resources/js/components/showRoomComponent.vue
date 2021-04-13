<template>
    <div>

        <b-sidebar  id="accessibility-sidebar" title="Colour Options" right shadow>
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
        <b-button hidden v-b-toggle.collapse-1 id="loadcanvas" variant="primary" class="clickable" style="margin-left:10px;"  ref="showCanvas">Check Availability</b-button>
        <b-collapse  id="collapse-1" class="mt-2">
            <b-card>
                <b-button v-b-toggle href="#accessibility-sidebar" @click.prevent class="clickable">Colour Options</b-button>
                <b-button id="resetZoom" class="clickable">Reset View</b-button>
                <b-button id="bookSeat" class="clickable" style="visibility:hidden" >Book Seat</b-button>

                <br/>
                <br/>
                <input type="input" id="inputSeatsTaken" value="[]" style="visibility:hidden;">

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
        watch: {
            // 'input_showcanvas': function(newVal, oldVal) {
            //     // console.log('value changed from ' + oldVal + ' to ' + newVal);
            //     const elem = this.$refs.showCanvas
            //     elem.click()
            // },
            'input_seatsTaken':function(newVal, oldVal){
                // console.log(newVal);
                // newVal.forEach(element => console.log(element['seat_name']));
                // console.log("new val :: " , newVal);
                // console.log(" seats taken :: ", this.seatsTaken);
                // console.log(newVal);
                const elem = this.$refs.showCanvas;
                elem.click();

                this.seatsTaken = [];
                newVal.forEach(element => this.seatsTaken.push(element['seat_name']));
                var hiddenField = document.getElementById('inputSeatsTaken');
                hiddenField.value = this.seatsTaken;
                hiddenField.dispatchEvent(new Event('change'));
                // el.trigger = 'change';
                // el.trigger = 'input';
                // el.value='New Value'
            }
            // console.log(this.seatsTaken);
        },

        components: {
            // VueTimepicker,
            // Datepicker,
        },


        props:['input_roomcanvas', 'input_showcanvas', 'input_seatsTaken', 'in_date', 'timeHH', 'timemm' ],

        data() {
            return{
                seatsTaken:this.input_seatsTaken,
            }
        },

        methods:{
        },

        mounted: function(){
            const elem = this.$refs.showCanvas
            elem.click()

            var taken = [];
            var temp = this.seatsTaken;
            var inputDate = this.in_date;
            var timeHH = this.timeHH;
            var timemm = this.timemm;

            temp.forEach(elements => taken.push(elements["seat_name"]));

            // console.log("Taken array :: " , taken);

            const ref = this.$refs.can;
            const canvas = new fabric.Canvas(ref);


            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            var height = (window.innerHeight > 0) ? window.innerHeight : screen.height;
            width = width*0.6;
            height = height*0.6;
            if(width>900) width=900;
            // console.log(width);
            canvas.setWidth(width);
            canvas.setHeight(height);

            // var backgroundURL = "/uploads/floor_plan/" + this.image_name;
            // var backgroundURL = "/uploads/floor_plan/" + this.image_name;
            // canvas.setBackgroundImage(backgroundURL, canvas.renderAll.bind(canvas));

            var $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;
            fabric.Group.prototype.hasControls = false
            fabric.Group.prototype.lockMovementX = true;
            fabric.Group.prototype.lockMovementY = true;

            var seatsTakenArray = $('inputSeatsTaken');
            seatsTakenArray.onchange = function(options) {
                canvas.forEachObject(function(object) {
                        if( object.get('type') != "group") return ;
                        object.item(0).set('fill', seatAvailable );
                        previousColourState.push(object.item(0).get('fill'));
                        object.selectable = true;
                });

                // console.log("change triggered");

                let taken = seatsTakenArray.value.split(",");

                // console.log(taken);

                canvas.forEachObject(function(object) {

                    let name1 = (object.get('name'));
                    let objName = name1.toString();

                    if (taken.includes(objName)) {

                        // console.log("Found  :: ", object.get('name'));

                        let objName = object.get('name');

                        objName = objName.toString();

                        if( taken.includes(objName)) {
                            object.item(0).set('fill', seatNotAvailable );
                            let index = object.get('name') ;
                            let fill = object.item(0).get('fill');
                            // console.log(object.get('name'));
                            // console.log(previousColourState);
                            previousColourState.splice(index , 0, fill);
                            // console.log(previousColourState);
                            // console.log(arr.join());

                            previousColourState.push(object.item(0).get('fill'));
                            object.selectable = false;
                            // console.log("notavailable");
                        }
                        else {
                            if( object.get('type') == "group") previousColourState.push(object.item(0).get('fill'));
                        }
                    }
                });
                var objects = canvas.getObjects();
                // for (var i in seatsTakenArray) {
                    // if (objects[i].name == 'referenceLength'){
                    //     objects[i].scaleX = this.value;
                    //     objects[i].scaleY = this.value;
                    // }
                    // console.log("Loop :: ", i);
                // }

                // objectRadius = this.value;
                // canvas.requestRenderAll();
            };


            // // Define variables
            let seatSelected = '#808080';
            let seatAvailable = '#baf312';
            let seatNotAvailable = '#ff0000';
            let previousColourState = [];

            //////////Draw Shapes
            // var circle = new fabric.Circle({
            //     radius: 50,
            //     left: 75,
            //     top: 75,
            //     fill: seatAvailable,
            //     name: 1,
            // });
            // console.log("___________________________");
            // console.log("CANVAS", this.input_roomcanvas);
            if(this.input_roomcanvas != ""){
                canvas.loadFromJSON(this.input_roomcanvas, canvas.renderAll.bind(canvas));
                canvas.requestRenderAll();

            }

            bookSeat.onclick = function(){
                // console.log("Booking");
                var obj = canvas.getActiveObject();
                var objName = obj.get('name');
                // this.$emit('clicked',[objName]);
                // console.log("Date :: ", inputDate);
                // console.log("Time HH  :: ", timeHH);
                // console.log("Time mm  :: ", timemm);

                const data = new FormData();

                const json = JSON.stringify({
                    'hour': timeHH,
                    'minute': timemm,
                    'date': inputDate,
                    'seat': objName,
                })
                data.append('data',json)
                return axios.post("/bookings/createBooking",data, {
                    headers: {
                        'Content-Type':'application/json',
                    },
                }).then(function(response) {
                    alert("Booking Successful");
                    window.location.replace("/");

                    // return (response);
                }).catch(e => {
                    console.log(e.messages);
                    this.errors = e.response.data.messages;
                    alert("Unable to book, please ensure you do not have another booking at this time in a different room");
                });



            }

            loadcanvas.onclick = function() {
                canvas.forEachObject(function(object) {
                    if( object.get('type') == "rect") object.visible = false;
                    if( object.get('type') == "group") object.item(1).visible = false;
                    if( object.get('type') == "line") object.visible = false;

                    // object.set('fill' ,'#1E88E5');
                    object.hasControls = false;
                    object.lockMovementX = true;
                    object.lockMovementY = true;
                    canvas.requestRenderAll();
                    // console.log("Begin render with");
                    // console.log("seats taken :: ", taken );


                });

                // console.log(this.input_roomcanvas);
                // console.log(this.input_seatsTaken);
                // setTakenSeats();
                changeColours('#808080','#baf312','#ff0000');
            }


            alterColour_01.onclick = function() { changeColours("#48453E","#1E88E5", "#FFC107");}

            alterColour_02.onclick = function() { changeColours("#48453E", "#40B0A6","#E1BE6A");}

            alterColour_03.onclick = function() { changeColours("#994F00", "#FEFE62", "#D35FB7" );}

            resetColours.onclick = function() { changeColours('#808080','#baf312','#ff0000');}

            resetZoom.onclick = function(){
                canvas.setViewportTransform([1,0,0,1,0,0]);
            }


            function changeColours(colour1,colour2,colour3){
                canvas.discardActiveObject();

                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    var index = object.get('name');

                    if(object.item(0).get('fill') == seatAvailable){
                        previousColourState[index] = colour2;
                        object.item(1).set('fill' ,colour2);
                        object.item(0).set('fill' ,colour2);
                    }
                    else if(object.item(0).get('fill') == seatNotAvailable) {
                        previousColourState[index] = colour3;
                        object.item(0).set('fill' ,colour3);
                        object.item(1).set('fill' ,colour3);

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
                    document.getElementById("bookSeat").style.visibility = "visible";

                }
                // console.log(e.target.get('name'));
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
                document.getElementById("bookSeat").style.visibility = "hidden";
            });

        },
    };
</script>
