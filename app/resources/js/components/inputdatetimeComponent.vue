import showCanvasComponent from "./showCanvasComponent.vue";

<template>
    <div>
        Select Date
        <datepicker></datepicker>
        <br/><br/>
        From <vue-timepicker v-model="time_input"  hide-disabled-hours :minute-interval="20" :hour-range="[ [time_opening, time_closing] ]" placeholder="Start Time" @change="checkAvailable"></vue-timepicker> &nbsp;To&nbsp;
        <vue-timepicker disabled v-model="time_end" id="time_end" placeholder="End Time"></vue-timepicker>



    <br/>
    </div>
</template>

<script>
    import { fabric } from 'fabric';

    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/antd.css'

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

    props:['roomcanvas'],

    // props:['roomcanvas'],
    // props:['image_name'],

    data() {
        return {
            timeFormat: 'hh:mm',

            time_opening: '6',
            time_closing: '20',

            time_input: {
                hh: '0',
                mm: '0'
            },

            time_end: {
                hh: '0',
                mm: '0'
            }
            // saveCanvasVar: "",
            // isError: false,
            // isChanged: true,
            // counter_seats: 0,
            // csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        }
    },

    methods: {
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

                this.time_end['hh'] = temp_hh;
                this.time_end['mm'] = temp_mm;

                var endTime = temp_hh + ":" + temp_mm;

                document.getElementById("time_end").placeholder = endTime;

            }
        },
    }
}
</script>
