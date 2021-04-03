<template>
    <div>


        <datetime-component :input_opentime=opentime :input_closetime=closetime @clicked="dateTimeInput"></datetime-component>

        <br/><br/>

        <showcanvas-component :input_showcanvas=showcanvas :input_roomcanvas=roomcanvas></showcanvas-component>
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
            }
        },

        methods:{
            dateTimeInput(value){
                // console.log(value);
                this.showcanvas = true;
                console.log(this.showcanvas);
            }

        },
        mounted: function(){
        },
    };
</script>
