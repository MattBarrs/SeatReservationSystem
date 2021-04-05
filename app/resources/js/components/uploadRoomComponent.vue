import showCanvasComponent from "./showRoomComponent.js";

<template>
    <div>
        Room Name<input type="input" v-model="room_name" value="room_name" @change="checkName">

        <br/><br/>
        <table>
            <tr>
                <td style="padding-bottom:15px;">Opening Time</td>
                <td style="padding-bottom:15px;"><vue-timepicker close-on-complete v-model="openingtime"  hide-disabled-hours :minute-interval="5"  placeholder="Opening Time"   @change="checkTime"></vue-timepicker></td>
            </tr>
            <tr>
                <td style="padding-bottom:15px;">Closing Time</td>
                <td style="padding-bottom:15px;"><vue-timepicker  id="closingtime" close-on-complete v-model="closingtime" :hour-range="[[minclosingtime,23]]"  hide-disabled-hours :minute-interval="5"  placeholder="Closing Time" @change="checkTime"></vue-timepicker></td>
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
        <input type="file"  id="floor_plan" name="floor_plan" @change="checkUpload">
            <br/><br/>

        <div v-if="errors" class="failAlertMessage">
            <div v-for="(v, k) in errors" :key="k">
                <p v-for="error in v" :key="error" class="text-sm">
                    {{ error }}
                </p>
            </div>
        </div>

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
        'validName': function(val,oldVal){
            this.checkVariables();
        },
        'validTime': function(val,oldVal) {
            this.checkVariables();
        },
        'validFile': function(val,oldVal) {
            this.checkVariables();
        },
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

            validName:false,
            validFile:false,
            validTime:false,

            errors:"",
        }
    },

    mounted() {
        document.getElementById("submitButton").style.visibility= "hidden";
        document.getElementById("missingFields").style.visibility= "visible";

    },

        methods: {



            toggle(source) {
                var checkboxes = document.getElementsByName('room_details');
                // console.log(checkboxes);
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    console.log(checkboxes[i].checked);
                    checkboxes[i].checked = true;
                }
            },

            untoggle(source) {
                var checkboxes = document.getElementsByName('room_details');
                // console.log(checkboxes);
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    // console.log(checkboxes[i].checked);
                    checkboxes[i].checked = false;
                }
            },

            checkVariables(event){
                // console.log(this.validName);
                // console.log("validName");
                // console.log(this.validFile);
                // console.log("validFile");
                // console.log(this.validTime);
                // console.log("validTime");

                if( this.validFile && this.validTime && this.validName){
                    document.getElementById("submitButton").style.visibility = "visible";
                    document.getElementById("missingFields").style.visibility= "hidden";

                }
                else{
                    document.getElementById("submitButton").style.visibility = "hidden";
                    document.getElementById("missingFields").style.visibility= "visible";
                }
            },

            checkName(event){
                if((this.room_name == null) || (this.room_name==="") ){
                    this.validName = false;
                }else{
                    this.validName = true;

                }
            },


            checkUpload(event){
                this.validFile = false;

                // console.log("chcking upload ");

                this.floor_plan = event.target.files[0];
                var uploadedFile =  document.getElementById("floor_plan").value;

                // console.log(uploadedFile);


                if( (uploadedFile != null) && (uploadedFile!="")   ) {
                    this.validFile = true;
                }
            },
            submit (event) {

                let temp_otime_hh = this.openingtime['HH'];
                let temp_otime_mm = this.openingtime['mm'];
                let openTime = temp_otime_hh +  ":" + temp_otime_mm;
                // console.log(openTime);

                let temp_ctime_hh = this.closingtime['HH'];
                let temp_ctime_mm = this.closingtime['mm'];
                let closeTime = temp_ctime_hh +  ":" + temp_ctime_mm;
                // console.log(closeTime);

                const data = new FormData();
                data.append('floor_plan', this.floor_plan);
                const json = JSON.stringify({
                    'open_time': openTime,
                    'close_time': closeTime,
                    'room_name':this.room_name,
                    'details': this.room_details,
                })
                data.append('data',json)
                axios.post("/rooms",data, {
                    headers: {
                        'Content-Type':'application/json',
                    },
                }).then(function(response) {
                    window.location.replace("/rooms/edit/");
                }).catch(e => {
                    this.errors = e.response.data.errors;
                });
            },


        checkTime(eventData) {
            this.validTime = false;

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
            // console.log(this.closingtime);

            if (closeTime != null){
                close_hh = closeTime['HH'];
                close_mm = closeTime['mm'];

                if (!(close_hh.includes("H")) && !(close_hh.includes("h")) && !(close_mm.includes("m")) && (close_mm != "") && (close_hh !="") ) {
                    if(close_hh == open_hh && close_mm<=open_mm){
                        document.getElementById("isTimeError").style.visibility = "visible"
                    }else{
                        document.getElementById("isTimeError").style.visibility = "hidden";
                        this.validTime = true;
                    };
                }
            }
            // console.log(this.closingtime);

        },


    }
}
</script>
