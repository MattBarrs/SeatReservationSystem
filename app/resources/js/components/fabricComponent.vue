<template>
    <div>

        <b-button v-b-toggle href="#accessibility-sidebar" @click.prevent class="clickable">Controls & Accessibilty</b-button>
        <b-button v-b-toggle.collapse-0 variant="primary" class="clickable" style="margin-left:10px;">Toggle Instructions</b-button>
        <b-collapse id="collapse-0" class="mt-2" style="width:95%">
            <b-card>
                Instructions:<br/>
                - 'ALT' + 'Left Click': Move view of canvas<br/>
                - 'Mouse wheel': Changes level of zoom<br/>
                - 'Alter Slider': Changes size of shapes<br/>
            </b-card>
        </b-collapse>

        <b-sidebar visible id="accessibility-sidebar" title="Controls & Accessibilty" shadow>
            <div class="px-3 py-2">
                <div class="accordion" role="tablist">
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.accordion-1 variant="info">Step 1: Mark Seating Area</b-button>
                        </b-card-header>
                        <b-collapse  visible id="accordion-1" accordion="task-accordion" role="tabpanel">
                            <b-card-body>
                                <b-card-text>Add a square to define where the seats must be within </b-card-text>
                                    <button id="addmore_seatingArea" class="clickable">Add Seating Area</button>
                                    <button id="addmore_exclusionArea" class="clickable">Add Exclusion Area</button>
                                    <button id="setSeatArea" class="clickable">Set Seat Area</button>
                                    <button id="unsetSeatArea" class="clickable">Unset Seat Area</button>
                                </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.accordion-2 variant="info">Step 2: Add Seats</b-button>
                        </b-card-header>
                        <b-collapse id="accordion-2" accordion="task-accordion" role="tabpanel">
                            <b-card-body>
                                <button id="addmore_seat" class="clickable">Add more Seats</button>
                                <br/>
                                Size of seats: <input type="range" id="scale-control" value="1" min="0.1" max="3" step="0.1">
                                <br/><br/>

                            </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.accordion-3 variant="info">Step 3: Group Seats Into Sections</b-button>
                        </b-card-header>
                        <b-collapse id="accordion-3" accordion="task-accordion" role="tabpanel">
                            <b-card-body>
                                <br/><br/>
                                <button id="saveCanvas" class="clickable">Save Canvas</button>

                                <div class="wrapper">
                                    <div v-if="isError">Save Status: Error Occured</div>
                                    <div v-else-if="isLoading">Save Status: Saving...</div>
                                    <div v-else="isLoading">Save Status: Saved.</div>
                                </div>

                                <br/><br/>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                </div>
            <button id="deleteSelection" class="redButton">Delete Selection</button>

            <form @submit.prevent="saveCanvas">
                <input type="hidden" name="title" v-model="saveCanvasVar">
                <input type="hidden" name="_token" :value="csrf">
                <input type="submit" value="Submit" class="clickable">
            </form>

        </div>


        <b-button v-b-toggle.collapse-1 variant="primary" class="clickable" style="margin-top:150px;margin-left:10px;">Toggle Colour Options</b-button>
        <b-collapse id="collapse-1" class="mt-2" style="width:95%">
            <b-card>
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



        <canvas ref="can" width="900" height="900"  style="border: 1px solid grey;"></canvas>

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
        props:['image_name'],
        mounted() {

            //Define + create canvas
            const ref = this.$refs.can;
            const canvas = new fabric.Canvas(ref);
            var backgroundURL = "/uploads/floor_plan/" + this.image_name;
            canvas.setBackgroundImage(backgroundURL, canvas.renderAll.bind(canvas));

            var $ = function(id){return document.getElementById(id)};
            fabric.Object.prototype.transparentCorners = false;
            // canvas.setBackgroundImage('../img/default_floorplan.jpg', canvas.renderAll.bind(canvas));


            // // Define variables
            var saveCanvasVar;
            var counter_seats = 1;
            var objectRadius = 1;
            var seatingAreaSet = false; //used for when the client sets the seating/exlusions areas
            var counter_seatingArea = 0;
            var counter_exclusionArea = 0;
            var seatColour = '#baf312';
            var seatColour_clash = '#ff0000';



            //////////Draw Shapes
            var circle = new fabric.Circle({
                radius: 50,
                left: 75,
                top: 75,
                fill: seatColour,
                name: 1,
            });

            canvas.add(circle);
            circle.hasControls = false;


            var circle2 = new fabric.Circle({
                radius: 50,
                left: 175,
                top: 75,
                fill: seatColour,
            });
            canvas.add(circle2);
            circle2.hasControls = false;





            var scaleControl = $('scale-control');
            scaleControl.oninput = function(options) {
                var objects = canvas.getObjects();
                for (var i in objects) {
                    if (objects[i].type == 'circle'){
                        objects[i].scaleX = this.value;
                        objects[i].scaleY = this.value;
                    }
                }

                objectRadius = this.value;
                canvas.requestRenderAll();
            };

            addmore_seatingArea.onclick = function() {
                if(seatingAreaSet == false){
                    var rectangle = new fabric.Rect({
                        left: 100,
                        top: 100,
                        width: 200,
                        height: 200,
                        strokeDashArray: [1, 1],
                        stroke: 'black',
                        strokeWidth: 3,
                        name: 'seatingArea',
                        fill: 'rgba(0,125,0,0.1)',
                    });
                    canvas.add(rectangle);
                    counter_seatingArea = counter_seatingArea + 1;
                }
                else{
                    alert("Seating Area Has been set, please un-set before adding more");
                    return;
                }
            }

            addmore_exclusionArea.onclick = function() {
                if(seatingAreaSet == false){

                    var rectangle = new fabric.Rect({
                        left: 100,
                        top: 100,
                        width: 200,
                        height: 200,

                        strokeDashArray: [1, 1],
                        stroke: 'black',
                        name: 'exclusionArea',
                        strokeWidth: 3,
                        fill: 'rgba(125,0,0,0.1)',
                    });
                    canvas.add(rectangle);
                    counter_exclusionArea = counter_exclusionArea + 1;
                }
                else{
                    alert("Seating Area Has been set, please un-set before adding more");
                    return;
                }
            }

            setSeatArea.onclick = function() {
                if(counter_seatingArea>0)
                {
                    var overlaps = false;
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
                        canvas.forEachObject(function(objx) {
                            if( objx.get('type') != "rect") return;
                            canvas.sendToBack(objx);
                            objx.selectable = false;
                        });
                    };
                    seatingAreaSet = true;

                }else {
                    alert("No seating area added.")
                }


            }
            unsetSeatArea.onclick = function() {
                canvas.discardActiveObject();
                canvas.forEachObject(function(obj) {
                    if( obj.get('type') != "rect") return;
                    obj.selectable = true;
                });
                seatingAreaSet = false;
            }
            // console.log(objectRadius);
            addmore_seat.onclick = function() {
                // console.log(objectRadius);
                if(seatingAreaSet == true) {
                    var seat = new fabric.Circle({
                        radius: 50,
                        left: 275,
                        top: 75,
                        fill: seatColour,
                        name: counter_seats,

                    });
                    canvas.add(seat);
                    seat.scaleX = objectRadius;
                    seat.scaleY = objectRadius;
                    seat.hasControls = false;

                    counter_seats = counter_seats + 1;
                }
                else{
                    alert("Seating Area Has Not Been Set!\nSet Seating Area To Allow Seats To Be Added")
                }
            }

            saveCanvas.onclick = function(){
                var errorFound = false;
                // var outOfBounds = false;
                var withinASeatingArea = false;
                var errorWhatIsWrong = "Could not save as: \n ";

                if(seatingAreaSet == false) {
                    errorFound = true;
                    errorWhatIsWrong = errorWhatIsWrong + "\n Seating Area Has Not Been Set!";

                }

                if(errorFound == false){
                    canvas.forEachObject(function(objx) {
                        withinASeatingArea = false;

                        if( objx.get('type') != "circle") return;
                        objx.set('fill' ,seatColour);

                        canvas.forEachObject(function (objz) {
                            if (objz.get('name') != 'seatingArea') return;
                            if (objx === objz) return;
                            if (objz.get('type') != "rect") return;

                            if (objx.isContainedWithinObject(objz) == true) {
                                withinASeatingArea = true;
                                console.log("FOUND IN SEATING AREAS");

                            }
                        });

                        try {

                            canvas.forEachObject(function (objy) {

                                if (objx === objy) return;
                                // if (errorFound == true) return;



                                if ((objy.get('name') == 'exclusionArea') && (objx.intersectsWithObject(objy))) {

                                    objx.set('fill', seatColour_clash);
                                    errorFound = true;
                                    errorWhatIsWrong = errorWhatIsWrong + "\n  - A seat overlaps with an exclusion zone";

                                    throw new Error('SeatPositionException');

                                }

                                if ((objy.get('name') == 'seatingArea') && !(objx.isContainedWithinObject(objy)) && (withinASeatingArea == false)) {
                                    objx.set('fill', seatColour_clash);
                                    errorFound = true;
                                    withinASeatingArea = false;
                                    errorWhatIsWrong = errorWhatIsWrong + "\n   - A seat is not fully in a zone";

                                    throw new Error('SeatPositionException');

                                }

                                if ((objy.get('type') == "circle") && (objx.intersectsWithObject(objy))) {
                                    objx.set('fill', seatColour_clash);
                                    errorFound = true;
                                    errorWhatIsWrong = errorWhatIsWrong + "\n   - A seat overlaps with another seat";


                                    throw new Error('SeatPositionException');
                                }
                                canvas.requestRenderAll();
                            });
                        }
                        catch (e){
                            var error = e;

                        }
                        finally {
                            axios.post('/post',{canvas:this.saveCanvasVar})
                                .then((response)=>{
                                    $('#success').html(response.data.message)
                                }
                            )
                        }



                        canvas.requestRenderAll();

                    });

                }

                if(errorFound == true){
                    alert(errorWhatIsWrong);
                }
                else {
                    saveCanvasVar = JSON.stringify(canvas)
                    document.getElementById('hiddenField').value = saveCanvasVar ;
                    document.getElementById("saveCanvasForm").submit();
                    alert("Save Successfull")
                }
            }


            

            deleteSelection.onclick = function() {
                var obj = canvas.getActiveObject();

                canvas.remove( canvas.getActiveObject()) ;

                if(obj.get('name') == 'seatingArea'){
                    counter_seatingArea = counter_seatingArea - 1;
                }else if( obj.get('name') == 'seatingArea'){
                    counter_exclusionArea = counter_exclusionArea - 1;

                }else if ( obj.get('circle') ) {
                    counter_seats = counter_seats - 1;
                }
            }

            discard.onclick = function() {
                canvas.discardActiveObject();
                canvas.requestRenderAll();
            }

            alterColour_01.onclick = function() {
                canvas.forEachObject(function(obj) {
                    if( obj.get('type') != "circle") return;
                    obj.set('fill' ,'#1E88E5');
                });
                seatColour = "#1E88E5";
                seatColour_clash = "#FFC107";
                canvas.requestRenderAll();

            }
            alterColour_02.onclick = function() {
                canvas.forEachObject(function(obj) {
                    if( obj.get('type') != "circle") return;
                    obj.set('fill' ,'#40B0A6');
                });
                seatColour = "#40B0A6";
                seatColour_clash = "#E1BE6A";
                canvas.requestRenderAll();

            }
            alterColour_03.onclick = function() {
                canvas.forEachObject(function(obj) {
                    if( obj.get('type') != "circle") return;
                    obj.set('fill' ,'#FEFE62');
                });
                seatColour = "#FEFE62";
                seatColour_clash = "#D35FB7";
                canvas.requestRenderAll();

            }
            resetColours.onclick = function() {
                canvas.forEachObject(function(obj) {
                    if( obj.get('type') != "circle") return;
                    obj.set('fill' ,'#baf312');
                });
                seatColour = "#baf312";
                seatColour_clash = "#ff0000";
                canvas.requestRenderAll();

            }



            canvas.on('mouse:wheel', function(opt) {
                var delta = opt.e.deltaY;
                // console.log(delta);

                var zoom = canvas.getZoom();
                zoom *= 0.999 ** delta;
                if (zoom > 3 ) zoom = 3;
                if (zoom < 0.75) zoom = 0.75;

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
                if( options.target.get('type') != "circle") return;

                canvas.forEachObject(function(obj) {
                    if (obj != options.target) {
                        if ((obj.get('type') == "rect") && (obj.get('name') == 'exclusionArea')) {
                            options.target.set('fill', options.target.intersectsWithObject(obj) ? seatColour_clash : seatColour);
                        } else {

                            if (obj.get('type') == "rect") return;
                            obj.set('fill', options.target.intersectsWithObject(obj) ? seatColour_clash : seatColour);

                            // if(options.target.fill === seatColour_clash) return;
                            // options.target.set('fill' ,obj.intersectsWithObject(options.target) ? seatColour_clash : seatColour);
                        }
                    }
                });
            };




            canvas.on({
                'object:moving': onChange,
                // 'object:scaling': updateControls,
                // 'object:modified' : borderCheck,

            });


        },
        methods:{
            async myMethod(){
                try{
                    this.isLoading = true;
                    const {data} = await this.$http.patch(
                        '/api/items',
                        {name:"my item"}
                    );
                }
                catch(err)
                {
                    this.isError = true;
                    console.log(err);
                }
                finally {
                    this.isLoading = false;
                }

            }
        },


        data: function () {
            return{
                saveCanvasVar: null,
                isLoading: false,
                isError: false,
                counter_seats: 0,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            }
        },

};
</script>
