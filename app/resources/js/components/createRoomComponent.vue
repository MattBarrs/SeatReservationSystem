<template>
    <div>



        <b-sidebar  id="accessibility-sidebar" title="Controls & Accessibilty" right shadow>
            <div class="px-3 py-2">
                <b-collapse visible class="mt-2">
                    <b-card>

                        <button id="discard" class="clickable">Discard Selection</button>
                        <button id="deleteSelection" class="redButton">Delete Object</button>

                        <div class="accordion" role="tablist">

                            <b-card no-body class="mb-1">
                                <b-card-header header-tag="header" class="p-1" role="tab">
                                     <b-button block v-b-toggle.accordion-0 variant="info" id="accordion-0">Step 1: Set Reference Length </b-button>
                                </b-card-header>

                                <b-collapse  visible id="accordion-0" accordion="task-accordion" role="tabpanel">
                                    <b-card-body>
                                        <div id="step1div">

                                        Scale reference<br/>
                                        <input type="range" id="reference-control" value="1" min="0.5" max="4" step="0.05">
                                        <br/>Angle reference<br/>
                                        <input type="range" id="rotate-control" value="0" min="0" max="360" step="1">

                                        <br/><br/>
                                        <p style="font-size: 15px">
                                            Real-Life Length (metres)
                                        </p>
                                        <input type="number" id="length_value" min="1" max="100"  style="width:50px;border-style:solid;border-width:4px;border-radius:4px;">
                                        <br/>
                                        <br/>
                                        <button id="setReference" class="clickable" name="setReference" >Set Reference</button>
                                        <button id="unsetReference" class="clickable" name="unsetReference" style="visibility:hidden;">Unset Reference</button>
                                        </div>
                                    </b-card-body>
                                </b-collapse>
                            </b-card>

                            <b-card no-body class="mb-1">
                                <b-card-header header-tag="header" class="p-1" role="tab">
                                    <b-button block v-b-toggle.accordion-1 variant="info" id="accordion-1">Step 2: Mark Seating Area</b-button>
                                </b-card-header>
                                <b-collapse  visible id="accordion-1" accordion="task-accordion" role="tabpanel">
                                    <b-card-body>
                                        <b-card-text>Add a square to define where the seats must be within </b-card-text>
                                            <button id="addmore_seatingArea" class="clickable">Add Seating Area</button>
                                            <button id="addmore_exclusionArea" class="clickable">Add Exclusion Area</button>
                                            <button id="setSeatArea" class="clickable"style="visibility:hidden;">Set Seat Area</button>
                                            <button id="unsetSeatArea" class="clickable" style="visibility:hidden;">Unset Seat Area</button>
                                        </b-card-body>
                                </b-collapse>
                            </b-card>

                            <b-card no-body class="mb-1">
                                <b-card-header header-tag="header" class="p-1" role="tab">
                                    <b-button block v-b-toggle.accordion-2 variant="info" id="accordion-2">Step 3: Add Seats</b-button>
                                </b-card-header>
                                <b-collapse id="accordion-2" accordion="task-accordion" role="tabpanel">
                                    <b-card-body>
                                        <button id="addmore_seat" class="clickable">Add More Seats</button>
                                        <br/>
                                        Size of seats: <input type="range" id="scale-control" value="1" min="0.1" max="3" step="0.1">
                                        <br/><br/>

                                    </b-card-body>
                                </b-collapse>
                            </b-card>

                            <b-card no-body class="mb-1">
                                <b-card-header header-tag="header" class="p-1" role="tab">
                                    <b-button block v-b-toggle.accordion-3 variant="info" id="accordion-3">Step 4: Save Canvas</b-button>
                                </b-card-header>
                                <b-collapse id="accordion-3" accordion="task-accordion" role="tabpanel">
                                    <b-card-body>
                                        <br/><br/>
                                        Social Distancing Minimum (metres)<input type="number" id="social_distance" min="1" max="20"  style="width:50px;border-style:solid;border-width:4px;border-radius:4px;">
                                        <br/>
                                        <br/>
                                        <button id="checkCanvas" class="clickable">Save Canvas</button>
                                        <button id="editSeats" class="clickable" style="margin-bottom:10px;visibility:hidden;">Edit Seat Details</button>
                                        <br/>
                                        <br/>

                                        <div id="referenceIsZero" style="visibility:hidden;">
                                            Warning reference Length is 0!
                                        </div>

                                        <br/>
                                        <br/>
                                    </b-card-body>

                                </b-collapse>
                            </b-card>
                        </div>
                        <div id="status box" style="width:75%;margin:auto;">
                            <div id="isUnsaved"  class="yellowBackground "  style="visibility:visible;border-radius:15px;border:2px solid black;">Unsaved Changes</div>
                            <div id="isSaved"  class="greenBackground"  style="visibility:hidden;border-radius:15px;border:2px solid black;" >Saved</div>
                            <div id="isError" class="redBackground" style="visibility:hidden;border-radius:15px;border:2px solid black;">Error</div>
                        </div>
                    </b-card>
                </b-collapse>
        </div>

        <br/>
        <br/>
        <br/>
        <br/>

        <b-collapse visible class="mt-2" style="width:90%;align:center;padding-left:10px;">
            <b-card>
                <button id="resetColours" class="clickable" style="margin-bottom:10px;">Reset Colours</button>

                <div class="accordion" role="tablist">
                    <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                    <b-button block v-b-toggle.accordion-4 variant="info">Colour Options 01</b-button>

                </b-card-header>
                <b-collapse id="accordion-4" accordion="colour-accordion" role="tabpanel">
                <b-card-body>
                <b-card-text>

                <div class="inline-block">
                <div class='sampleBox blue'/>
                    &nbsp;Seat
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox yellow'/>
                    &nbsp;Error With Seat
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
                <div class='sampleBox blue2'/>
                    &nbsp;Seat
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox yellow2'/>
                    &nbsp;Error With Seat
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
                <div class='sampleBox yellow3'/>
                    &nbsp;Seat
                </div>
                <br/>

                <div class="inline-block">
                <div class='sampleBox pink'/>
                    &nbsp;Error With Seat
                </div>
                <br/>

                <button id="alterColour_03" class="clickable">Activate</button>
                    </b-card-text>
                    </b-card-body>
                    </b-collapse>
                    </b-card>
                    </div>
            </b-card>
        </b-collapse>


                </b-collapse>

        </b-sidebar>


    <br/><br/>
    <b-button v-b-toggle.collapse-1 id="loadcanvas" variant="primary" class="clickable" href="#accessibility-sidebar" >Edit Room</b-button>
    <b-collapse id="collapse-1" class="mt-2">
        <b-card>
            <b-button v-b-toggle href="#accessibility-sidebar" @click.prevent class="clickable">Controls & Accessibilty</b-button>

            <b-button v-b-toggle.collapse-0 variant="primary" class="clickable" style="margin-left:10px;">Toggle Instructions</b-button>
            <b-button id="resetZoom" class="clickable">Reset View</b-button>
            <br/>
            <br/>
            <b-collapse id="collapse-0" class="mt-2" style="width:95%">
                <b-card>
                    Set reference length so that distance can be checked
                    Instructions:<br/>
                    - 'ALT' + 'Left Click': Move view of canvas<br/>
                    - 'Mouse wheel': Changes level of zoom<br/>
                    - 'Alter Slider': Changes size of shapes<br/>
                </b-card>
            </b-collapse>

            <canvas ref="can" width="750" height="750"  style="border: 1px solid grey;"></canvas>
        </b-card>
    </b-collapse>

<br/>


</div>
</template>

<script>
    import { fabric } from 'fabric';
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'
    // import { VBToggle } from 'bootstrap-vue'
    //  Vue.directive('b-toggle', VBToggle)
    import { VBTogglePlugin } from 'bootstrap-vue'
    Vue.use(VBTogglePlugin)
    export default {

        components: {
            VueSlider
        },


        props:['image_name', 'previouscanvas'],
        //all lower case as does not like uppercase

        data() {
            return{
                length_value:0,
                saveCanvasVar: "",
                isError: false,
                isChanged: true,
                counter_seats: 0,
                // csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            }
        },



        mounted: function(){
            // // Define variables
            let distanceFactor=0;
            let counter_seats = 1;
            let objectRadius = 1;
            let seatingAreaSet = false; //used for when the client sets the seating/exlusions areas
            let referenceSet = false; //used for when the client sets the seating/exlusions areas
            let counter_seatingArea = 0;
            let counter_exclusionArea = 0;
            let seatColour = '#baf312';
            let seatColour_clash = '#ff0000';
            // let saveCanvasVar = null;
            let isError = false;
            let isChanged = true;


            //Define + create canvas
            const ref = this.$refs.can;
            const canvas = new fabric.Canvas(ref);

            if(this.previouscanvas != "None" ){
                canvas.loadFromJSON(this.previouscanvas, canvas.renderAll.bind(canvas));
                seatingAreaSet = true;
                canvas.requestRenderAll();
                document.getElementById("unsetSeatArea").style.visibility = "visible";
                document.getElementById("setSeatArea").style.visibility = "hidden";
                document.getElementById("addmore_seatingArea").style.visibility = "hidden";
                document.getElementById("addmore_exclusionArea").style.visibility = "hidden";
                document.getElementById("setReference").style.visibility = "visible";
                document.getElementById("step1div").style.visibility = "visible";
                document.getElementById("unsetReference").style.visibility = "hidden";
            }
            else{
                let backgroundURL = "/uploads/floor_plan/" + this.image_name;
                canvas.setBackgroundImage(backgroundURL, canvas.renderAll.bind(canvas));
                // //////////Draw Shapes
                let referenceLength = new fabric.Line([75,0,0,0],{
                        left:170,
                        top:150,
                        stroke:'red',
                        strokeWidth:5,
                    }

                );
                referenceLength.toObject = (function(toObject) {
                    return function() {
                        return fabric.util.object.extend(toObject.call(this), {
                            name: this.name
                        });
                    };
                })(referenceLength.toObject);

                referenceLength.name = 'referenceLength';
                canvas.add(referenceLength);
                referenceLength.hasControls = false;
            }

            let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
            let height = (window.innerHeight > 0) ? window.innerHeight : screen.height;
            width = width*0.6;
            height = height*0.6;
            if(width>900) width=900;

            canvas.setWidth(width);
            canvas.setHeight(height);


            let $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;

            let value_length = $('length_value');
            let social_distance = $('social_distance');


            let referenceControl = $('reference-control');
            referenceControl.oninput = function(options) {
                let objects = canvas.getObjects();
                for (let i in objects) {
                    if (objects[i].name == 'referenceLength'){
                        objects[i].scaleX = this.value;
                        // objects[i].scaleY = this.value;
                    }
                }

                objectRadius = this.value;
                canvas.requestRenderAll();
            };

            let rotateControl = $('rotate-control');
            rotateControl.oninput = function(options) {
                let objects = canvas.getObjects();
                for (let i in objects) {
                    if (objects[i].name == 'referenceLength'){
                        objects[i].rotate(this.value);
                    }
                }

                objectRadius = this.value;
                canvas.requestRenderAll();
            };

            let scaleControl = $('scale-control');
            scaleControl.oninput = function(options) {
                let objects = canvas.getObjects();
                for (let i in objects) {
                    if (objects[i].type == 'group'){
                        objects[i].scaleX = this.value;
                        objects[i].scaleY = this.value;
                    }
                }

                objectRadius = this.value;
                canvas.requestRenderAll();
            };

            function setReferenceLength(){

                if (value_length.value >= 1) {
                    // console.log(value_length.value)

                    canvas.forEachObject(function (object) {
                        if (object.get('name') != "referenceLength") return;

                        let virtualLength = object.scaleX * object.x1;
                        distanceFactor = virtualLength / value_length.value;

                        document.getElementById("setReference").style.visibility = "hidden";
                        document.getElementById("step1div").style.visibility = "hidden";
                        document.getElementById("unsetReference").style.visibility = "visible";
                        document.getElementById("accordion-1").click();

                        canvas.forEachObject(function (objx) {
                            if (objx.get('name') != "referenceLength") return;
                            canvas.sendToBack(objx);
                            objx.visible = false;
                        });
                    });
                };
            }

            setReference.onclick = function() {
                setReferenceLength();
            }

            function unsetReferenceLength(){
                document.getElementById("setReference").style.visibility = "visible";
                document.getElementById("step1div").style.visibility = "visible";
                document.getElementById("unsetReference").style.visibility = "hidden";

                canvas.forEachObject(function (objx) {
                    if (objx.get('name') != "referenceLength") return;
                    canvas.sendToBack(objx);
                    objx.visible = true;
                });
            }

            unsetReference.onclick = function(){
                unsetReferenceLength()
            }



            loadcanvas.onclick = function() {
                canvas.forEachObject(function(object) {
                    object.toObject = (function(toObject) {
                        return function() {
                            return fabric.util.object.extend(toObject.call(this), {
                                name: this.name
                            });
                        };
                    })(object.toObject);

                    console.log( object.get('name') );


                    // if (object.get('name') == 'referenceLength') {
                    //     object.visible = false;
                    //
                    // } else
                    if (object.get('name') == 'seatingArea') {
                        counter_seatingArea = counter_seatingArea + 1;
                        canvas.sendToBack(object);
                        object.selectable = false;
                    } else if (object.get('name') == 'referenceLength') {
                            object.hasControls = false;

                    } else if (object.get('name') == 'exclusionArea') {
                        counter_exclusionArea = counter_exclusionArea + 1;
                        canvas.sendToBack(object);
                        object.selectable = false;

                    } else if (object.get('type') == 'group') {
                        counter_seats = counter_seats + 1;
                        object.hasControls = false;
                    }
                });
                canvas.forEachObject(function(objx) {
                    // console.log(objx.get('name'));
                    if( objx.get('type') != "rect") return;
                    canvas.sendToBack(objx);
                    objx.selectable = false;
                });
            }

            addmore_seatingArea.onclick = function() {

                if(seatingAreaSet == false){
                    document.getElementById("setSeatArea").style.visibility = "visible";

                    let rectangle = new fabric.Rect({
                        left: 100,
                        top: 100,
                        width: 200,
                        height: 200,
                        strokeDashArray: [1, 1],
                        stroke: 'black',
                        strokeWidth: 3,
                        fill: 'rgba(0,125,0,0.1)',
                    });

                    rectangle.toObject = (function(toObject) {
                        return function() {
                            return fabric.util.object.extend(toObject.call(this), {
                                name: this.name
                            });
                        };
                    })(rectangle.toObject);

                    canvas.add(rectangle);
                    rectangle.name = 'seatingArea';
                    // console.log(rectangle.name);
                    counter_seatingArea = counter_seatingArea + 1;
                }
                else{
                    alert("Seating Area Has been set, please un-set before adding more");
                    return;
                }
            }

            addmore_exclusionArea.onclick = function() {
                if(seatingAreaSet == false){

                    let rectangle = new fabric.Rect({
                        left: 100,
                        top: 100,
                        width: 200,
                        height: 200,

                        strokeDashArray: [1, 1],
                        stroke: 'blue',
                        strokeWidth: 8,
                        fill: 'rgba(125,0,0,0.1)',
                    });
                    rectangle.toObject = (function(toObject) {
                        return function() {
                            return fabric.util.object.extend(toObject.call(this), {
                                name: this.name
                            });
                        };
                    })(rectangle.toObject);

                    canvas.add(rectangle);
                    rectangle.name = 'exclusionArea';
                    counter_exclusionArea = counter_exclusionArea + 1;
                }
                else{
                    alert("Seating Area Has been set, please un-set before adding more");
                    return;
                }
            }



            function setSeatingArea(){
                if(counter_seatingArea>0)
                {
                    let overlaps = false;
                    canvas.discardActiveObject();

                    try{
                        canvas.forEachObject(function(objx) {
                            if( objx.get('type') != "rect") return;

                            if( objx.get('name') == 'seatingArea'){
                                canvas.forEachObject(function(objy) {
                                    if((objy.get('name') == 'exclusionArea') && (objx.intersectsWithObject(objy)) ){
                                        alert("A Seating Area overlaps with an Exclusion zone please change!");
                                        overlaps = true;
                                        throw BreakException;
                                    }
                                });
                            };

                        });
                    }
                    catch (e){
                        if (e !== BreakException) throw e;

                    }


                    if(overlaps==false){
                        document.getElementById("unsetSeatArea").style.visibility = "visible";
                        document.getElementById("setSeatArea").style.visibility = "hidden";
                        document.getElementById("addmore_seatingArea").style.visibility = "hidden";
                        document.getElementById("addmore_exclusionArea").style.visibility = "hidden";

                        canvas.forEachObject(function(objx) {
                            if( objx.get('type') != "rect") return;
                            canvas.sendToBack(objx);
                            objx.selectable = false;
                        });
                    };
                    seatingAreaSet = true;
                    document.getElementById("accordion-2").click();

                }else {
                    alert("No seating area added.")
                }


            }

            setSeatArea.onclick = function() {
                setSeatingArea();
            }
            unsetSeatArea.onclick = function() {
                canvas.discardActiveObject();
                canvas.forEachObject(function(object) {
                    if( object.get('type') != "rect") return;
                    object.selectable = true;
                });
                seatingAreaSet = false;
                document.getElementById("unsetSeatArea").style.visibility = "hidden";
                document.getElementById("setSeatArea").style.visibility = "visible";
                document.getElementById("addmore_seatingArea").style.visibility = "visible";
                document.getElementById("addmore_exclusionArea").style.visibility = "visible";
            }



            addmore_seat.onclick = function() {

                if(seatingAreaSet == true) {
                    let circle = new fabric.Circle({
                        radius: 50,
                        left: 275,
                        top: 75,
                        fill: seatColour,
                        strokeWidth: 2,
                        stroke: "black",
                    });

                    let seatName = counter_seats.toString();
                    let text = new fabric.Text(seatName,{
                        top:125,
                        left:325,
                        textAlign: 'center',
                        originX: 'center',
                        originY: 'center',
                        fontSize: 20,
                    });

                    let seat = new fabric.Group([circle,text]);

                    seat.toObject = (function(toObject) {
                        return function() {
                            return fabric.util.object.extend(toObject.call(this), {
                                name: this.name
                            });
                        };
                    })(seat.toObject);

                    canvas.add(seat);
                    seat.name = counter_seats;

                    seat.scaleX = objectRadius;
                    seat.scaleY = objectRadius;
                    seat.hasControls = false;

                    counter_seats = counter_seats + 1;
                }
                else{
                    alert("Seating Area Has Not Been Set!\nSet Seating Area To Allow Seats To Be Added")
                }
            };

            function checkDistance(){
                let distanceFail = false;

                canvas.forEachObject(function (objA) {

                    if( objA.get('name') != "seatingArea") return;

                    canvas.forEachObject(function(seatA) {
                        if (! (seatA.isContainedWithinObject(objA)) )return;
                        if( seatA.get('type') != "group") return;

                        // console.log("Object data :: " , seatA);
                        let temp_x1 = seatA.left;
                        let temp_y1 = seatA.top;

                        canvas.forEachObject(function (seatB) {
                            if (seatA === seatB) return;
                            if( seatB.get('type') != "group") return;
                            if (! (seatB.isContainedWithinObject(objA)) )return;
                            console.log("Comparing :: ", seatA.get('name') ,' :: ', seatB.get('name'));

                            let temp_x2 = seatB.left;
                            let temp_y2 = seatB.top;

                            let a = temp_x1 - temp_x2;
                            let b = temp_y1 - temp_y2;
                            let digitalDistance = Math.sqrt( a*a + b*b );
                            // let distanceInReality = distanceFactor*digitalDistance;
                            let social_distanceOnCanvas = social_distance.value * distanceFactor;


                            // console.log("digital distance"  , digitalDistance);
                            // console.log(" real distance " , distanceInReality);
                            // console.log("social distance on canvas" , social_distanceOnCanvas);

                            if(digitalDistance < social_distanceOnCanvas){
                                seatA.item(0).set('fill', seatColour_clash);
                                seatB.item(0).set('fill', seatColour_clash);
                                distanceFail = true;
                            }
                            // console.log(digitalDistance);
                        });
                    });




                });





                return distanceFail;
            };

            checkCanvas.onclick = function(){
                isError = false;
                document.getElementById("isError").style.visibility = "visible";
                document.getElementById("isSaved").style.visibility = "hidden";
                document.getElementById("isUnsaved").style.visibility = "hidden";
                document.getElementById("editSeats").style.visibility = "hidden";
                document.getElementById("referenceIsZero").style.visibility = "hidden";

                // let outOfBounds = false;
                let withinASeatingArea = false;
                let errorWhatIsWrong = "Could not save as: \n ";

                if( value_length.value == 0){
                    document.getElementById("referenceIsZero").style.visibility = "visible";
                }

                if(seatingAreaSet == false) {
                    isError = true;
                    errorWhatIsWrong = errorWhatIsWrong + "\n -Seating Area Has Not Been Set!";
                }

                if(counter_seats ==0){
                    isError = true;
                    errorWhatIsWrong = errorWhatIsWrong + "\n -No seats added.";
                }

                if(isError == false){
                    canvas.forEachObject(function(objx) {
                        withinASeatingArea = false;

                        if( objx.get('type') != "group") return;
                        objx.item(0).set('fill' ,seatColour);

                        canvas.forEachObject(function (objz) {
                            if (objz.get('name') != 'seatingArea') return;
                            if (objx === objz) return;

                            if (objx.isContainedWithinObject(objz)){ withinASeatingArea = true; }
                        });

                        try {

                            canvas.forEachObject(function (objy) {

                                if (objx === objy) return;
                                // if (errorFound == true) return;



                                if ((objy.get('name') == 'exclusionArea') && (objx.intersectsWithObject(objy))) {

                                    objx.item(0).set('fill', seatColour_clash);
                                    isError = true;
                                    errorWhatIsWrong = errorWhatIsWrong + "\n  - A seat overlaps with an exclusion zone";

                                    throw new Error('SeatPositionException');

                                }

                                // if ((objy.get('name') == 'seatingArea') && !(objx.isContainedWithinObject(objy)) && (withinASeatingArea == false)) {
                                if (withinASeatingArea == false) {
                                    objx.item(0).set('fill', seatColour_clash);
                                    isError = true;
                                    withinASeatingArea = false;
                                    errorWhatIsWrong = errorWhatIsWrong + "\n   - Seat '"+objx.get('name')+"' is not fully in a zone";

                                    throw new Error('SeatPositionException');

                                }
                                if ((objy.get('type') == "group") && (objx.intersectsWithObject(objy))) {
                                    objx.item(0).set('fill', seatColour_clash);
                                    isError = true;
                                    errorWhatIsWrong = errorWhatIsWrong + "\n   - A seat overlaps with another seat";


                                    throw new Error('SeatPositionException');
                                }
                                canvas.requestRenderAll();
                            });
                        }
                        catch (e){
                            let error = e;
                        }
                        finally{

                            canvas.requestRenderAll();
                        }

                    });

                }

                if (checkDistance()){
                    errorWhatIsWrong = errorWhatIsWrong + "\n   - Seats Are Below The Minimum Safe Distance";
                    isError= true;
                }

                if(isError == true){
                    // document.getElementById("saveButton").style.visibility = "hidden";
                    alert(errorWhatIsWrong);
                }
                else {
                    isError = false;

                    let temp = [];
                    temp.push(seatColour);
                    temp.push(seatColour_clash);

                    canvas.forEachObject(function (object) {
                        object.visible = true;
                    });

                    changeColours('#baf312','#ff0000');

                    this.saveCanvasVar = JSON.stringify(canvas);
                    console.log(this.saveCanvasVar);
                    changeColours(temp[0],temp[1]);
                    canvas.forEachObject(function (object) {
                        if (object.get('name') != 'referenceLength') return;
                        object.visible = false;
                    });
                    // console.log(JSON.stringify(canvas));
                    // console.log(this.saveCanvasVar);
                    // document.getElementById("saveButton").style.visibility = "visible";
                    try{
                        let obj = this;
                        obj.isChanged = true;

                        axios.post('/rooms/saveCanvas', {
                            canvas: obj.saveCanvasVar,
                            // canvas: canvasObject,
                        }).then(function(response) {
                            // console.log("Save Success");
                            // console.log(response);
                        }).catch(function(error) {
                            // console.log("Error with Save");
                            // console.log(error);
                        })

                    }
                    catch(err)
                    {
                        isError = true;
                    }
                    finally {
                        isChanged = false;
                        document.getElementById("isSaved").style.visibility = "visible";
                        document.getElementById("editSeats").style.visibility = "visible";
                        document.getElementById("isUnsaved").style.visibility = "hidden";
                        document.getElementById("isError").style.visibility = "hidden";
                    }
                }
            }




            deleteSelection.onclick = function() {
                let object = canvas.getActiveObject();

                if(object.type != "line"){
                    canvas.remove( canvas.getActiveObject()) ;
                }

                if(object.get('name') == 'seatingArea'){
                    counter_seatingArea = counter_seatingArea - 1;
                }else if( object.get('name') == 'exclusionArea'){
                    counter_exclusionArea = counter_exclusionArea - 1;

                }else{
                    counter_seats = counter_seats - 1;
                }
            }

            discard.onclick = function() {
                canvas.discardActiveObject();
                canvas.requestRenderAll();
            }

            alterColour_01.onclick = function() { changeColours("#1E88E5", "#FFC107");}

            alterColour_02.onclick = function() { changeColours( "#40B0A6", "#E1BE6A");}

            alterColour_03.onclick = function() { changeColours("#FEFE62", "#D35FB7" );}

            resetColours.onclick = function() { changeColours('#baf312', '#ff0000');}

            resetZoom.onclick = function(){
                canvas.setViewportTransform([1,0,0,1,0,0]);
            }


            function changeColours(colour1,colour2){
                canvas.discardActiveObject();

                canvas.forEachObject(function(object) {
                    if( object.get('type') != "group") return;
                    // console.log(object.item(0));
                    if(object.item(0).get('fill') == seatColour){
                        object.item(0).set('fill' ,colour1);
                    }
                    else if(object.item(0).get('fill') == seatColour_clash) {
                        object.item(0).set('fill' ,colour2);

                    }

                });
                seatColour = colour1;
                seatColour_clash = colour2;

                canvas.requestRenderAll();

            }


            canvas.on('selection:created', (e) => {
                if(e.target.type === 'activeSelection') {
                    canvas.discardActiveObject();
                }
            })
            canvas.on('mouse:wheel', function(opt) {
                let delta = opt.e.deltaY;

                let zoom = canvas.getZoom();
                zoom *= 0.999 ** delta;
                if (zoom > 8 ) zoom = 8;
                if (zoom < 0.25) zoom = 0.25;

                canvas.zoomToPoint({ x: opt.e.offsetX, y: opt.e.offsetY }, zoom);
                opt.e.preventDefault();
                opt.e.stopPropagation();
            });



            canvas.on('mouse:down', function(opt) {
                let evt = opt.e;
                if (evt.altKey === true) {
                    this.isDragging = true;
                    this.selection = false;
                    this.lastPosX = evt.clientX;
                    this.lastPosY = evt.clientY;
                }
            });


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


            canvas.on('mouse:up', function(opt) {
                // on mouse up we want to recalculate new interaction
                // for all objects, so we call setViewportTransform
                this.setViewportTransform(this.viewportTransform);
                this.isDragging = false;
                this.selection = true;
            });

            function onChange(options) {
                if(isChanged == false){
                    document.getElementById("isSaved").style.visibility = "hidden";
                    document.getElementById("editSeats").style.visibility = "hidden";
                    document.getElementById("isUnsaved").style.visibility = "visible";
                    isChanged = true;
                }

                options.target.setCoords();
                if( options.target.get('type') != "group") return;

                canvas.forEachObject(function(object) {
                    if (object != options.target) {

                        if ((object.get('type') == "rect") && (object.get('name') == 'exclusionArea')) {
                            options.target.item(0).set('fill', options.target.intersectsWithObject(object) ? seatColour_clash : seatColour);
                        }
                        else {

                            if (object.get('type') != "group") return;
                            object.item(0).set('fill', options.target.intersectsWithObject(object) ? seatColour_clash : seatColour);

                        }
                    }
                });
            };

            canvas.on({
                'object:moving': onChange,
            });

            editSeats.onclick = function() {
                window.location.replace("/rooms/editseats/");
            }
        },
    };
</script>
