import showCanvasComponent from "./showRoomComponent.js";

<template>
    <div>
        <label for ="room_name">Room Name
        <input type="input" v-model="room_name" value="room_name">

        <div class="tooltip" style="width:10%;height:10%;">
        <img src="/img/question.png" class="inline" alt="RoomCode Tooltip" title="Please ask your local admim or staff if you do not the room code"></a>
            <span class="tooltiptext">
            Name for the room - So it's easier for people to remember
        </span>
        </div>
        </label>


        <br/><br/>
        <table>
            <tr>
                <td style="padding-bottom:15px;">Opening Time</td>
                <td style="padding-bottom:15px;"><vue-timepicker close-on-complete v-model="openingtime"  hide-disabled-hours :minute-interval="5"  placeholder="Opening Time"   @change="checkVariables"></vue-timepicker></td>
            </tr>
            <tr>
                <td style="padding-bottom:15px;">Closing Time</td>
                <td style="padding-bottom:15px;"><vue-timepicker  id="closingtime" close-on-complete v-model="closingtime" :hour-range="[[minclosingtime,23]]"  hide-disabled-hours :minute-interval="5"  placeholder="Closing Time" @change="checkVariables"></vue-timepicker></td>
            </tr>
            <div id="isTimeError" class="redBackground hiddenError" style="width:100%">Invalid Time</div>
        </table>

        <br/>


    <br/><br/>
        <b>Room Facilities & Details</b>
        <br/>
        <button class="clickable" @click="toggle"> Select All</button>
        <button class="clickable" @click="untoggle"> De-Select All</button><br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Catering" id="Catering"> Catering
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Disabled Toilets" id="Disabled Toilets"> Disabled Toilets
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Guide-dog Friendly" id="Guide-dog Friendly">Guide Dog Friendly
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Wheelchair Access" id="Wheelchair Access">Wheel Chair Access
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Lifts" id="Lifts">Lifts
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Prayer Room" id="Prayer Room">Prayer Room
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Quiet Room" id="Quiet Room">Quiet Room
        <br/>
        <input type="checkbox" name="room_details" v-model="room_details" value="Toilets" id="Toilets">Toilets
        <br/>

        <label for ="floor_plan">Upload floor plan of room</label>
        <input type="file"  id="floor_plan" name="floor_plan" @change="checkVariables">
            <br/><br/>

        <div id="missingFields" class="redBackground hiddenError">Missing Fields</div>
        <button id="submitButton" class="clickable" value="Submit"  @click="submit"> Submit</button>

</form>


    <br/>
    </div>
</template>

<script>

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

    watch: {

    },

    props:['input_opentime','input_closetime'],

    data() {
        return {
            openingtime:null,
            closingtime:null,
            floor_plan:null,
            file_floorplan:null,
            room_name:"Fight Arena",
            room_details:[],

            minclosingtime:null,
            isEmpty:true,
        }
    },

    mounted() {
        document.getElementById("submitButton").style.visibility= "hidden";
        document.getElementById("missingFields").style.visibility= "visible";

    },

        methods: {



            toggle(source) {
                var checkboxes = document.getElementsByName('room_details');
                console.log(checkboxes);
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    console.log(checkboxes[i].checked);
                    checkboxes[i].checked = true;
                }
            },

            untoggle(source) {
                var checkboxes = document.getElementsByName('room_details');
                console.log(checkboxes);
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    console.log(checkboxes[i].checked);
                    checkboxes[i].checked = false;
                }
            },

            checkVariables(event){
                console.log("checkingVariables");
                var timeValid = this.updateTime();
                var uploadValid = this.checkUpload();
                var nameValid = this.checkName();
                console.log(timeValid);
                console.log(uploadValid);

                if( timeValid && uploadValid){
                    document.getElementById("submitButton").style.visibility = "visible";
                    document.getElementById("missingFields").style.visibility= "hidden";

                }
                else{
                    document.getElementById("submitButton").style.visibility = "hidden";
                    document.getElementById("missingFields").style.visibility= "visible";
                }
            },

            checkName(event){
                var checkBool=false;
                var name = this.room_name;

                if((name!= null) || (name!="") ){
                    checkBool=true;
                }
                return checkBool;
            },


            checkUpload(event){
                var checkBool = false;
                console.log("chcking upload ");
                var uploadedFile =  document.getElementById("floor_plan").value;
                console.log(uploadedFile);


                if( (uploadedFile != null) && (uploadedFile!="")   ) {
                    checkBool = true;
                }

                return checkBool;
            },

            submit (event){
            try{
                let obj = this;
                obj.isChanged = true;


                var name = this.room_name;
                var openTime = this.openingtime;
                var closeTime = this.closingtime;
                var details = this.room_details;

                const object = {
                    room_name: name,
                    // open_time: openTime,
                    // close_time: closeTime,
                    // room_details: details,
                };

                const json = JSON.stringify(object);
                const blob = new Blob([json],{
                    type:'application/json'
                });

                const formData = new FormData();
                formData.append("data",json);
                // formData.append("data",blob);

                const file_floorplan = document.querySelector('#floor_plan');
                formData.append("file", file_floorplan.files[0]);

                for (var key of formData.entries()) {
                    console.log(key[0] + ', ' + key[1]);
                }

                axios.post('/rooms', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                    data:formData,

                }).then(function(response) {
                    console.log("Save Success");
                    // console.log(response);
                }).catch(function(error) {
                    console.log("Error with Save");
                    console.log("ERRRR:: ",error.response.data.errors);
                    // console.log(error);
                })
                // axios.post('/rooms', {
                //     room_name: this.room_name,
                //     open_time:this.openingtime,
                //     close_time: this.closingtime,
                //     floor_plan:this.floor_plan,
                //     room_details:this.room_details,
                // })

            }
            catch(error){
                console.log("ERRRR:: ",error.response.data);
            };

        },


        updateTime(eventData) {
            // console.log("Open", this.openingtime);
            var checkBool = false;
            console.log(this.closingtime);
            var openTime = this.openingtime;
            var closeTime = this.closingtime;

            var open_hh;
            var open_mm;
            var close_hh;
            var close_mm;

            if (openTime != null){
                open_hh = openTime['HH'];
                open_mm = openTime['mm'];

                if (!(open_hh.includes("H")) && !(open_hh.includes("h")) &&  (open_hh !="") ) {
                    this.minclosingtime = parseInt(open_hh);
                }
                // if (!(open_hh.includes("H")) && !(open_hh.includes("h")) && !(open_mm.includes("m")) && (open_mm != "") && (open_hh !="") ) {
                //     document.getElementById("closingtime").disabled = false;
                // }
            }
            console.log(this.closingtime);

            if (closeTime != null){
                close_hh = closeTime['HH'];
                close_mm = closeTime['mm'];

                if (!(close_hh.includes("H")) && !(close_hh.includes("h")) && !(close_mm.includes("m")) && (close_mm != "") && (close_hh !="") ) {
                    if(close_hh == open_hh && close_mm<=open_mm){
                        document.getElementById("isTimeError").style.visibility = "visible"
                    }else{
                        document.getElementById("isTimeError").style.visibility = "hidden";
                        checkBool = true;
                    };
                }
            }
            console.log(this.closingtime);

            return checkBool;
        },


    }
}
</script>
