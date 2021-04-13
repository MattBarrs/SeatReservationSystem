<template>
    <div>
       <datetime-component :input_opentime=opentime :input_closetime=closetime @clicked="dateTimeInput"></datetime-component>
        <br/><br/>
        <div v-if="showcanvas">
         <showcanvas-component :input_showcanvas=showcanvas :input_roomcanvas=roomcanvas  :input_seatsTaken=seatsUnavailable :in_date=startDate :timeHH=startTimeHH :timemm=startTimemm   ></showcanvas-component>
        </div>
<br/>


</div>
</template>

<script>
    import { VBToggle } from 'bootstrap-vue'
     Vue.directive('b-toggle', VBToggle)

    import { VBTogglePlugin } from 'bootstrap-vue'
    Vue.use(VBTogglePlugin)


export default {

        components: {
            // VueSlider,
        },


        props:['roomcanvas', 'opentime','closetime'],

        data() {
            return{
                showcanvas: false,
                seatsUnavailable: null,
                startTimeHH:null,
                startTimemm:null,
                startDate:null,


            }
        },


        methods:{
            dateTimeInput(value){

                console.log(value);
                if( value[0] == false) {
                    // console.log("False detected");
                    setTimeout(this.setHide()   , 10);
                }
                else{

                    // console.log(value[0]["HH"])
                    // console.log(value[0]["mm"])
                    // console.log(value[1])
                    this.postData(value).then((result)=>{
                            // console.log("Test")
                            // console.log("Result" + result)
                            // console.log(Object.prototype.toString.call(result))

                            result.data[0].forEach(element => console.log(element));

                            this.seatsUnavailable = result.data[0];
                            this.startTimeHH = value[0]['HH'];
                            this.startTimemm = value[0]['mm'];

                            this.endTimeHH = value[1]['HH'];
                            this.endTimemm = value[1]['mm'];
                            this.startDate = value[2]

                            setTimeout(this.setShow, 10);
                            // console.log(this.showcanvas);

                        }
                    )
                }
                // console.log(value);
            },

            setShow(){
                this.showcanvas = true;
            },
            setHide(){
                this.showcanvas = false;
            },


            postData : async(value) => {

                console.log(value);
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

        },
        mounted: function(){
        },
    };
</script>
