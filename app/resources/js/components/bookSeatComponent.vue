<template>
    <div>


        <datetime-component></datetime-component>

        <br/><br/>

        <showcanvas-component :input_roomcanvas=roomcanvas></showcanvas-component>
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


export default {

        components: {
            VueSlider,
        },


        props:['roomcanvas'],
        // props:['image_name'],

        data() {
            return{



                // saveCanvasVar: "",
                // isError: false,
                // isChanged: true,
                // counter_seats: 0,
                // csrf: document.head.querySelector('meta[name="csrf-token"]').content,
            }
        },

        methods:{

        },

        mounted: function(){

        },
    };
</script>
