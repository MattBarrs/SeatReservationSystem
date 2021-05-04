import showCanvasComponent from "./showRoomComponent.js";

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
                <div class='sampleBox darkGreen'/>-
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


        Select Date

        <datepicker :calendar-button="true" v-model="date_input" :disabled-dates="uptoToday" @input="checkVariables"></datepicker>
        <div id="isDateError" class="redBackground hiddenError" >Invalid Date</div>

        <br/><br/>
        From <vue-timepicker v-model="time_start"  hide-disabled-hours :minute-interval="20" :hour-range="[ [timeOpen_hh, timeClose_hh] ]" placeholder="Start Time" @change="checkAvailable"></vue-timepicker> &nbsp;To&nbsp;
        <vue-timepicker disabled v-model="time_end" id="time_end" placeholder="End Time"></vue-timepicker>
        <br/>
        <div style="font-size:15px;"> Room Opens at: {{ timeOpen_hh}}:{{timeOpen_mm}}</div>
        <div style="font-size:15px;"> Room Closes at: {{ timeClose_hh}}:{{timeClose_mm}}</div>


        <div id="isTimeError" class="redBackground hiddenError" >Invalid Time</div>
        <button style="visibility:hidden;" @click="checkVariables()" class="clickable" id="showAvailable">Show Availability</button>


        <b-button hidden v-b-toggle.collapse-1 id="loadcanvas" variant="primary" class="clickable" style="margin-left:10px;"  ref="showCanvas">Check Availability</b-button>
            <b-collapse  id="collapse-1" class="mt-2">
                <b-card>
                    <b-button v-b-toggle href="#accessibility-sidebar" @click.prevent class="clickable">Colour Options</b-button>
                    <b-button id="resetZoom" class="clickable">Reset View</b-button>
                    <b-button id="bookSeat" class="clickable" style="visibility:hidden" >Book Seat</b-button>

                    <br/>
                    <br/>
                    <input type="input" id="inputSeatsTaken" value="[]" style="visibility:hidden;">

                    <input type="input" id="hidden_time_start_hh" value="[]" style="visibility:hidden;">
                    <input type="input" id="hidden_time_start_mm" value="[]" style="visibility:hidden;">

                    <input type="input" id="hidden_time_end_hh" value="[]" style="visibility:hidden;">
                    <input type="input" id="hidden_time_end_mm" value="[]" style="visibility:hidden;">


                    <input type="input" id="hidden_date" value="[]" style="visibility:hidden;">

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

    import 'vue2-timepicker/dist/VueTimepicker.css'
    import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue'

    import Datepicker from 'vuejs-datepicker';

export default {

    components: {
        VueTimepicker,
        Datepicker,
    },

    props:['roomcanvas', 'opentime','closetime'],
    //opetime and close is the open/close of the room

    watch: {

        //watch and hidden fields used as the canvas can only be run in mounted
        //in order to pass dynamic variables to mounted a hidden field is used
        /**
         *
         * @param newVal
         * @param oldVal
         */
        'date_input':function(newVal, oldVal){
            let hidden_time = document.getElementById('hidden_date');
            let date = newVal.getUTCFullYear() +"/"+ (newVal.getUTCMonth()+1) +"/"+ newVal.getUTCDate();
            hidden_time.value = date;
            hidden_time.dispatchEvent(new Event('change'));
        },

        /**
         *
         * @param newVal
         * @param oldVal
         */
        'time_start': function(newVal, oldVal){
            let hidden_time_hh = document.getElementById('hidden_time_start_hh');
            let hidden_time_mm = document.getElementById('hidden_time_start_mm');
            hidden_time_hh.value = newVal['HH'];
            hidden_time_mm.value = newVal['mm'];
            hidden_time_hh.dispatchEvent(new Event('change'));
            hidden_time_mm.dispatchEvent(new Event('change'));
        },

        /**
         *
         * @param newVal
         * @param oldVal
         */
        'time_end': function(newVal, oldVal){
            let hidden_time_hh = document.getElementById('hidden_time_end_hh');
            let hidden_time_mm = document.getElementById('hidden_time_end_mm');
            hidden_time_hh.value = newVal['HH'];
            hidden_time_mm.value = newVal['mm'];
            hidden_time_hh.dispatchEvent(new Event('change'));
            hidden_time_mm.dispatchEvent(new Event('change'));
        },

        /**
         *
         * @param newVal
         * @param oldVal
         */
        'input_seatsTaken':function(newVal, oldVal){
            this.seatsTaken = [];

            if(newVal.length >= 1) {
                newVal.forEach(element => console.log(element['seat_name']));
                newVal.forEach(element => this.seatsTaken.push(element['seat_name']));
            }

            let hiddenField = document.getElementById('inputSeatsTaken');
            hiddenField.value = this.seatsTaken;
            hiddenField.dispatchEvent(new Event('change'));

        }
    },

    data() {
        return {
            date_input:null,

            ///time the room opens/closes
            timeClose_hh:null,
            timeClose_mm:null,
            timeOpen_hh:null,
            timeOpen_mm:null,

            //start time of booking
            time_start: {
                HH: null,
                mm: null,
            },

            //end time of booking
            time_end: {
                HH: '0',
                mm: '0'
            },

            //stops using from booking historic booking
            uptoToday: {
                'to': new Date()
            },

            input_seatsTaken:null,
            seatsTaken:null,
        }
    },

    mounted() {

            let temp_split;

            temp_split = this.opentime.split(":");
            this.timeOpen_hh = temp_split[0];
            this.timeOpen_mm = temp_split[1];

            temp_split = this.closetime.split(":");
            this.timeClose_hh = temp_split[0];
            this.timeClose_mm = temp_split[1];

            //show the canvas
            const elem = this.$refs.showCanvas
            elem.click()

            //initialise canvas
            const ref = this.$refs.can;
            const canvas = new fabric.Canvas(ref);

            //get width of the screen
            let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            let height = (window.innerHeight > 0) ? window.innerHeight : screen.height;
            width = width*0.6;
            height = height*0.6;

            //limit canvas width
            if(width>900) width=900;

            canvas.setWidth(width);
            canvas.setHeight(height);

            //set the controls for the canvas
            let $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;
            fabric.Group.prototype.hasControls = false //stops group controls
            fabric.Group.prototype.lockMovementX = true; //stops group movement x
            fabric.Group.prototype.lockMovementY = true; //stops group movement y

            /**
             * locks the seats which are not available
             * @param options
             */
            let seatsTakenArray = $('inputSeatsTaken');
            seatsTakenArray.onchange = function(options) {

                //reset all  seats
                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return ;

                    object.item(0).set('fill', seatAvailable );

                    let index = object.get('name');
                    previousColourState[index] = object.item(0).get('fill');
                    object.selectable = true;
                });
                canvas.requestRenderAll();


                //split array of unavailable seats
                let taken = seatsTakenArray.value.split(",");

                canvas.forEachObject(function(object) {

                    let name1 = (object.get('name'));
                    let objName = name1.toString();

                    //check if name of seat is in the unavailable list
                    if( taken.includes(objName))
                    {
                        //set the colour as unavailable
                        object.item(0).set('fill', seatNotAvailable );
                        let index = object.get('name') ;
                        let fill = object.item(0).get('fill');

                        //save remove old colour value
                        previousColourState.splice(index , 0, fill);
                        //add new colour value
                        previousColourState.push(object.item(0).get('fill'));

                        //disable selection
                        object.selectable = false;
                    }
                    else {
                        if( object.get('type') == "group") previousColourState.push(object.item(0).get('fill'));
                    }
                });
                canvas.requestRenderAll();
            };


            // // Define variables
            let seatSelected = '#808080';
            let seatAvailable = '#baf312';
            let seatNotAvailable = '#ff0000';
            let previousColourState = [];

            if(this.roomcanvas != ""){
                canvas.loadFromJSON(this.roomcanvas, canvas.renderAll.bind(canvas));
                canvas.requestRenderAll();

            }


            /**
             *  send booking details via axios post
             *
             * @returns {Promise<AxiosResponse<any>>}
             */
            bookSeat.onclick = function(){

                //get values for post
                let obj = canvas.getActiveObject();
                let objName = obj.get('name');

                let time_end_hh = $('hidden_time_end_hh').value;
                let time_end_mm = $('hidden_time_end_mm').value;

                let time_start_hh = $('hidden_time_start_hh').value;
                let time_start_mm = $('hidden_time_start_mm').value;

                let date = $('hidden_date').value;

                const data = new FormData();

                const json = JSON.stringify({
                    'start_hour': time_start_hh,
                    'start_minute': time_start_mm,
                    'end_hour': time_end_hh,
                    'end_minute': time_end_mm,
                    'date': date,
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
                    this.errors = e.response.data.messages;
                    alert("Unable to book, please ensure you do not have another booking at this time in a different room");
                });



            }

            //when canvas is loaded
            loadcanvas.onclick = function() {
                canvas.forEachObject(function(object) {
                    //hide seating zones
                    if( object.get('type') == "rect") object.visible = false;
                    //hide seat numbers
                    if( object.get('type') == "group") object.item(1).visible = false;
                    //hide reference line
                    if( object.get('type') == "line") object.visible = false;

                    object.hasControls = false;
                    object.lockMovementX = true;
                    object.lockMovementY = true;
                    canvas.requestRenderAll();

                });
                canvas.requestRenderAll();

                changeColours('#808080','#baf312','#ff0000');
            }

            //colour blind option 1
            alterColour_01.onclick = function() { changeColours("#48453E","#1E88E5", "#FFC107");}
            //colour blind option 1
            alterColour_02.onclick = function() { changeColours("#48453E", "#40B0A6","#E1BE6A");}
            //colour blind option 1
            alterColour_03.onclick = function() { changeColours("#994F00", "#FEFE62", "#D35FB7" );}
            //resets colours to original
            resetColours.onclick = function() { changeColours('#808080','#baf312','#ff0000');}




            /**
             *changes the colour of the seats
             * @param colour1 :: seat selected colour
             * @param colour2 :: seats  Available colour
             * @param colour3 :: seats not Available colour
             */
            function changeColours(colour1,colour2,colour3){
                canvas.discardActiveObject();

                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return; //only seats

                    let index = object.get('name');

                    if(object.item(0).get('fill') == seatAvailable){
                        previousColourState[index] = colour2;
                        object.item(0).set('fill' ,colour2);
                        object.item(1).set('fill' ,colour2);
                    }
                    else{
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

            //reset the zoom/camera view
            resetZoom.onclick = function(){
                canvas.setViewportTransform([1,0,0,1,0,0]);
            }

            //changes the zoom
            canvas.on('mouse:wheel', function(opt) {
                let delta = opt.e.deltaY;

                //limters on zooming in or out
                let zoom = canvas.getZoom();
                zoom *= 0.999 ** delta;
                if (zoom > 8 ) zoom = 8;
                if (zoom < 0.25) zoom = 0.25;

                canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
                opt.e.preventDefault();
                opt.e.stopPropagation();
            });


            //used for moving the camera view on click
            canvas.on('mouse:down', function(opt) {
                let evt = opt.e;
                this.isDragging = true;
                this.selection = false;
                this.lastPosX = evt.clientX;
                this.lastPosY = evt.clientY;
            });

            //used for moving the camera view on click
            canvas.on('mouse:move', function(opt) {
                if (this.isDragging) {
                    let e = opt.e;
                    let vpt = this.viewportTransform;
                    vpt[4] += e.clientX - this.lastPosX;
                    vpt[5] += e.clientY - this.lastPosY;
                    this.requestRenderAll();
                    this.lastPosX = e.clientX;
                    this.lastPosY = e.clientY;
                }
            });

            //used for moving the camera view on click
            //when the mouse is up, set the view
            canvas.on('mouse:up', function(opt) {
                this.setViewportTransform(this.viewportTransform);
                this.isDragging = false;
                this.selection = true;
            });

            //seat selected
            canvas.on('selection:created', (e) => {

                //reset colours
                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    let index = object.get('name');
                    let colour = previousColourState[index];

                    object.item(0).set('fill',colour);
                });


                //active selection is a group selection
                //group selection is disabled
                if(e.target.type === 'activeSelection') {
                    canvas.discardActiveObject();
                } else {
                    //set colour to show seat is selected
                    e.target.item(0).set('fill',seatSelected);
                    document.getElementById("bookSeat").style.visibility = "visible";

                }
            })

            //new seat selected
            canvas.on('selection:updated', (e) => {
                //reset colours
                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;

                    let index = object.get('name');
                    let colour = previousColourState[index];

                    object.item(0).set('fill',colour);
                });

                //active selection is a group selection
                //group selection is disabled
                if(e.target.type === 'activeSelection') {
                    canvas.discardActiveObject();
                } else {
                    //set colour to show seat is selected
                    e.target.item(0).set('fill',seatSelected);
                }
            })

            //when selection is cleared reset all the colours
            canvas.on('selection:cleared', function() {
                canvas.forEachObject(function(object) {

                    //only seats/groups change colour
                    if( object.get('type') != "group") return;

                    let index = object.get('name');
                    let colour = previousColourState[index];

                    object.item(0).set('fill',colour);
                });
                //hide book button
                document.getElementById("bookSeat").style.visibility = "hidden";
            });
        },

        methods: {
            /**
             * gets the seats that are taken for the given data/time
             * @param value
             */
            getAvailabilty(value){
                    this.postData(value).then((result)=>{ this.input_seatsTaken = result.data[0];});
            },
            postData : async(value) => {

                const data = new FormData();

                const json = JSON.stringify({
                    'start_hour': value[0]['HH'],
                    'start_minute': value[0]['mm'],

                    'end_hour': value[1]['HH'],
                    'end_minute': value[1]['mm'],

                    'date': value[2],
                })
                data.append('data',json)
                return axios.post("/bookings/getAvailable",data, {
                    headers: {
                        'Content-Type':'application/json',
                    },
                }).then(function(response) {

                    return (response);
                }).catch(e => {
                    this.errors = e.response.data.errors;
                    alert("Unable to book seat.\nPlease contact local admin if problem persists.");
                });

            },
        /**
         * ensures variables are valid
         * @param event
         */
        checkVariables (event){
            try{
                document.getElementById("isTimeError").style.visibility = "hidden";
                document.getElementById("isDateError").style.visibility = "hidden";

                let temp_hh = this.time_start['HH'];
                let temp_mm= this.time_start['mm'];
                let temp_date = this.date_input;
                let errorFound = false;

                if( (temp_mm == null) || (temp_hh == null) || (temp_mm == "") || (temp_hh == "") ) {
                    errorFound = true;
                    document.getElementById("isTimeError").style.visibility = "visible";
                }
                else if( (temp_hh.includes("H") ) || (temp_hh.includes("h")) || (temp_mm.includes("newVal")) ){
                    errorFound = true;
                    document.getElementById("isTimeError").style.visibility = "visible";
                }


                let close_split = this.closetime.split(":");
                let open_split = this.opentime.split(":");
                let end_hh =  this.time_end['HH'];
                let end_mm = this.time_end['mm'] ;



                if( (end_hh == null) || (end_mm == null) || (end_hh == "") || (end_mm == "") || close_split == null ) {
                    errorFound = true;
                    document.getElementById("isTimeError").style.visibility = "visible";
                }
                else if( (end_hh == close_split[0] && end_mm>close_split[1]) || end_hh<open_split[0] || end_hh > close_split[0] ){
                    errorFound = true;
                    document.getElementById("isTimeError").style.visibility = "visible";
                }

                if( (temp_date == null) || (temp_date == "") ){
                    errorFound = true;
                    document.getElementById("isDateError").style.visibility = "visible";
                }

                //if error is found inform them and hide the canvas
                if(errorFound == false) {

                    this.getAvailabilty([this.time_start, this.time_end,  this.date_input]);
                    document.getElementById("showAvailable").style.visibility = "visible";

                    const elem = this.$refs.showCanvas;
                    elem.click();


                }else{
                    document.getElementById("showAvailable").style.visibility = "hidden";
                }
            }catch(error){}

        },



            /**
            *   checks that the time given doesnt:
            *    go past closing time
            *    is not before open time
            * @param eventData
            */
        checkAvailable(eventData) {

            if (!(eventData['displayTime'].includes("H")) && !(eventData['displayTime'].includes("h")) && !(eventData['displayTime'].includes("newVal")) && eventData['displayTime'] != "") {
                let timeInterval = 59;

                let temp_split = eventData['displayTime'].split(":");

                let temp_hh, temp_mm;
                temp_split[0] = parseInt(temp_split[0]);
                temp_split[1] = parseInt(temp_split[1]);

                if (temp_split[1] + timeInterval > 60) {
                    temp_mm = temp_split[1] + timeInterval;
                    let remainder = temp_mm % 60;
                    let divisions = (temp_mm - remainder) / 60;

                    temp_hh = temp_split[0] + divisions;
                    temp_mm = remainder;
                    if (temp_hh >= 24) temp_hh = temp_hh % 24;

                } else {

                    temp_hh = parseInt(temp_split[0]);
                    temp_mm = parseInt(temp_split[1]) + timeInterval;


                }

                this.time_end['HH'] = temp_hh;
                this.time_end['mm'] = temp_mm;

                let hidden_time_hh = document.getElementById('hidden_time_end_hh');
                let hidden_time_mm = document.getElementById('hidden_time_end_mm');
                hidden_time_hh.value = temp_hh;
                hidden_time_mm.value = temp_mm;

                let endTime = temp_hh + ":" + temp_mm;

                document.getElementById("time_end").placeholder = endTime;
                this.checkVariables();

            }
        },
    }
}
</script>
