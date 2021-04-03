import showCanvasComponent from "./showRoomComponent.js";

<template>
    <div>
        Select Date


        <datepicker v-model="date_input" :disabled-dates="uptoToday" ></datepicker>
        <div id="isDateError" class="redBackground hiddenError" >Invalid Date</div>

        <br/><br/>

        From <vue-timepicker close-on-complete v-model="time_input"  hide-disabled-hours :minute-interval="20" :hour-range="[ [timeOpen, timeClose] ]" placeholder="Start Time" @change="checkAvailable"></vue-timepicker> &nbsp;To&nbsp;
        <vue-timepicker disabled v-model="time_end" id="time_end" placeholder="End Time"></vue-timepicker>
        <br/>
        <div id="isTimeError" class="redBackground hiddenError" >Invalid Time</div>
        <button @click="onClickButton()" class="clickable">Submit</button>


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

    props:['input_opentime','input_closetime'],

    data() {
        return {
            // timeFormat: 'hh:mm',

            date_input:null,
            timeClose:null,
            timeOpen:null,

            time_input: {
                hh: null,
                mm: null,
            },

            time_end: {
                hh: '0',
                mm: '0'
            },

            uptoToday: {
                'to': new Date()
            },

        }
    },

    mounted() {
        var temp_split;
        temp_split = this.input_opentime.split(":");
        this.timeOpen = temp_split[0];
        temp_split = this.input_closetime.split(":");
        this.timeClose = temp_split[0];
    },

        methods: {

        onClickButton (event){
            try{
                // console.log(this.time_input['HH']);
                // console.log(this.time_input['mm']);
                // console.log(this.date_input);

                var temp_hh = this.time_input['HH'];
                var temp_mm= this.time_input['mm'];
                var temp_date = this.date_input;
                var errorFound = false;

                // if(  (Number.isInteger(this.time_input['HH']) ) && (Number.isInteger(this.time_input['mm']) ) && (this.time_input['HH'] != "")  && (this.time_input['mm'] != "") ){
                if( (temp_hh.includes("H") ) || (temp_hh.includes("h")) || (temp_mm.includes("m")) || (temp_mm == null) || (temp_hh == null) || (temp_mm == "") || (temp_hh == "") ) {
                    errorFound = true;
                    document.getElementById("isTimeError").style.visibility = "visible";
                }

                if( (temp_date == null) || (temp_date == "") ){
                    errorFound = true;
                    document.getElementById("isDateError").style.visibility = "visible";
                }

                if(errorFound == false) {
                    document.getElementById("isTimeError").style.visibility = "hidden";
                    document.getElementById("isDateError").style.visibility = "hidden";
                    this.$emit('clicked',[this.time_input, this.date_input]);

                }
                // this.$emit('clicked',"CLICKED");
            }
            catch ( error){

            }

        },

        checkAvailable(eventData) {
            if (!(eventData['displayTime'].includes("H")) && !(eventData['displayTime'].includes("h")) && !(eventData['displayTime'].includes("m")) && eventData['displayTime'] != "") {
                var timeInterval = 59;

                var temp_split = eventData['displayTime'].split(":");

                var temp_hh, temp_mm;
                temp_split[0] = parseInt(temp_split[0]);
                temp_split[1] = parseInt(temp_split[1]);

                if (temp_split[1] + timeInterval > 60) {
                    // console.log("IF");
                    temp_mm = temp_split[1] + timeInterval;
                    var remainder = temp_mm % 60;
                    var divisions = (temp_mm - remainder) / 60;

                    temp_hh = temp_split[0] + divisions;
                    temp_mm = remainder;
                    if (temp_hh >= 24) temp_hh = temp_hh % 24;

                } else {
                    // console.log("Else");

                    temp_hh = parseInt(temp_split[0]);
                    temp_mm = parseInt(temp_split[1]) + timeInterval;


                }

                // console.log(eventData['displayTime']);
                /*console.log(eventData['data']);

                console.log(temp_mm);
                console.log(temp_hh);*/

                this.time_end['HH'] = temp_hh;
                this.time_end['mm'] = temp_mm;

                var endTime = temp_hh + ":" + temp_mm;

                document.getElementById("time_end").placeholder = endTime;

            }
        },
    }
}
</script>
