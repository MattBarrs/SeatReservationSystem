import showCanvasComponent from "./showRoomComponent.js";

<template>
    <div>
        Select Date


        <datepicker v-model="date_input" :disabled-dates="uptoToday"></datepicker>
        <div id="isDateError" class="redBackground hiddenError" >Invalid Date</div>

        <select  v-model="institute_input" id="institutes"></select>
        <select v-model="room_input" id="rooms"></select>

        <br/><br/>
        Start Time <vue-timepicker close-on-complete v-model="time_input"  hide-disabled-hours :minute-interval="20" placeholder="Time"></vue-timepicker>
        <br/>
        <div id="isTimeError" class="redBackground hiddenError" >Invalid Time</div>
        <button @click="submit()" class="clickable">Submit</button>


        <div id="isContact" style="border:2px;visibility:hidden;">
            <p>
            Please Contact<br/>
            {{ contactEmails}}
            </p>
        </div>
        <div id="noContacts" style="visibility:hidden;border-style: solid;border-thickness:2px;border-radius:10px;">
            <p>No contacts found </p>
        </div>

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

        props:['institutes','rooms'],

    data() {
        return {
            date_input:null,
            time_input:null,
            room_input:null,
            institute_input:null,
            uptoToday: {
                'from': new Date()
            },

            contactEmails:null,


        }
    },

    mounted() {
        var institutes = this.institutes;
        institutes.forEach( element=>  this.addOption(element,"institutes"));

        var rooms = this.rooms;
        rooms.forEach( element=>  this.addOption(element,"rooms"));
    },

    methods: {

        addOption(text , target){
            var x = document.getElementById(target);
            var option = document.createElement("option");

            if (target == "institutes"){ option.text = text["institution_name"];}
            else if (target == "rooms"){ option.text = text["room_name"];}

            x.add(option);
            },

        returnEmail(string){
            string = JSON.parse(string);
            return string["email"];
        },

        submit (event){

            var date = this.date_input;
            var time = this.time_input;
            var room = this.room_input;
            var institute = this.institute_input;
            this.postData(date,time,room,institute).then((result)=> {

                var temp = result.data[0];

                if (temp.length >= 1){
                    document.getElementById("noContacts").style.visibility = "hidden";
                    document.getElementById("isContact").style.visibility = "visible";

                    this.contactEmails = [];
                    temp.forEach(element => this.contactEmails.push(element)  );

                    var addresses = this.contactEmails;//between the speech mark goes the receptient. Seperate addresses with a ;
                    var body = "To Whom It May Concern," +
                        "%0D%0A%0D%0A I regret to inform you that you came into contact with someone that had coronavirus."+
                        "%0D%0A You will need to get a COVID-19 test. Please self-isolate if possible till your test." +
                        "%0D%0A For advice on how long to self-isolate, go to https://www.nhs.uk/coronavirus and read ‘Self-isolation and treating symptoms’." +

                        "%0D%0A%0D%0A It happened at the: '"+ room + "'" +
                        "%0D%0A This occurred on: "+date+
                        "%0D%0A%0D%0A Thank you for understanding in these unprecedented times%0D%0A%0D%0A%0D%0A";
                        "%0D%0A%0D%0A Contact 111 if you need medical help. In an emergency, dial 999.%0D%0A%0D%0A%0D%0A";

                    var subject = "Coronavirus - Track and Trace: Self Isolation"

                    var href = "mailto:" + addresses + "?"
                        + "subject=" + subject + "&"
                        + "body=" + body;

                    var wndMail;
                    wndMail = window.open(href, "_blank", "scrollbars=yes,resizable=yes,width=100,height=100");
                    // if(wndMail)
                    // {
                    //     wndMail.close();
                    // }

                }
                else{
                    this.contactEmails = "None";
                    document.getElementById("isContact").style.visibility = "hidden";
                    document.getElementById("noContacts").style.visibility = "visible";


                }

            });


        },


        postData : async(date,time,room,institute) => {
            const data = new FormData();
            const json = JSON.stringify({
                'date': date,
                'room': room,
                'institute': institute,
                'time': time,
            })
            data.append('data',json)
            return axios.post("/trackAndTrace",data, {
                headers: {
                    'Content-Type':'application/json',
                },
            }).then(function(response) {
                return (response);
            }).catch(e => {
                this.errors = e.response.data.errors;
            });
        },



    }
}
</script>
