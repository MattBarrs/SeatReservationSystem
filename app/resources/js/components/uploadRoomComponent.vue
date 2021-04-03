import showCanvasComponent from "./showRoomComponent.js";

<template>
    <div>
        <label for ="room_name">Room Name
        <div class="tooltip" style="width:2%;height:2%;">
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
                <td style="padding-bottom:15px;"><vue-timepicker close-on-complete v-model="openingtime"  hide-disabled-hours :minute-interval="5"  placeholder="Opening Time"   @change="updateTime"></vue-timepicker></td>
            </tr>
            <tr>
                <td style="padding-bottom:15px;">Closing Time</td>
                <td style="padding-bottom:15px;"><vue-timepicker  id="closingtime" close-on-complete v-model="closingtime" :hour-range="[[minclosingtime,23]]"  hide-disabled-hours :minute-interval="5"  placeholder="Closing Time" ></vue-timepicker></td>
            </tr>
        </table>

        <br/>




    <br/><br/>
        <b>Room Facilities & Details</b>
        <fieldset>
        <input type="checkbox" name="room_details[]" value="Catering"> Catering
        <br/>
        <input type="checkbox" name="room_details[]" value="DisabledToilets"> Disabled Toilets
        <br/>
        <input type="checkbox" name="room_details[]" value="GuideDogFriendly">Guide Dog Friendly
        <br/>
        <input type="checkbox" name="room_details[]" value="WheelChairAccess">Wheel Chair Access
        <br/>
        <input type="checkbox" name="room_details[]" value="Lifts">Lifts
        <br/>
        <input type="checkbox" name="room_details[]" value="PrayerRooms">Prayer Room
        <br/>
        <input type="checkbox" name="room_details[]" value="QuietRoom">Quiet Room
        <br/>
        <input type="checkbox" name="room_details[]" value="Toilets">Toilets
        <br/>
        </fieldset>

        <label for ="floor_plan">Upload floor plan of room</label>
        <input type="file" id="floor_plan" name="floor_plan">
            <br/><br/>

        <input type="submit" value="Submit" class="clickable">
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

    props:['input_opentime','input_closetime'],

    data() {
        return {
            openingtime:null,
            closingtime:null,
            minclosingtime:null,
        }
    },

    mounted() {

    },

        methods: {

        onClickButton (event){
            try{
                let obj = this;
                obj.isChanged = true;

                axios.post('/rooms/saveCanvas', {
                    canvas: obj.saveCanvasVar,
                    // canvas: canvasObject,
                }).then(function(response) {
                    console.log("Save Success");
                    // console.log(response);
                }).catch(function(error) {
                    console.log("Error with Save");
                    // console.log(error);
                })

            }
            catch ( error){

            }

        },

        updateTime(eventData) {
            console.log("Open", this.openingtime);
            var openTime = this.openingtime;
            var temp_hh = openTime['HH'];
            var temp_mm = openTime['mm'];


            // if (!(temp_hh.includes("H")) && !(temp_hh.includes("h")) && !(temp_mm.includes("m")) && (temp_mm != "") && (temp_hh !="") ) {
            if (!(temp_hh.includes("H")) && !(temp_hh.includes("h")) &&  (temp_hh !="") ) {
                this.minclosingtime = parseInt(temp_hh);
            }
            if (!(temp_hh.includes("H")) && !(temp_hh.includes("h")) && !(temp_mm.includes("m")) && (temp_mm != "") && (temp_hh !="") ) {
                document.getElementById("closingtime").disabled = false;
            }
        }


    }
}
</script>
