<template>
  <div>
    <div class="display2left"></div>
    <div class="display2right"><displaycomponent :displaylist="displaylist"></displaycomponent></div>
  </div>

</template>
<script>
  import displaycomponent from './component/displaycomponent.vue';
  export default{
   props:['displaydata'],
    components: {
      displaycomponent
    },
    data() {
      return {
        displaylist: {},
        // context: null
      }
    },
    mounted:function(){
      this.displaylist = this.displaydata;
      // console.log(this.displaydata)
    },
  //   methods:{
  //     // Jumpdisplay(item){
  //     //  console.log(item)
  //     // }
        
  // }
    }

</script>
<style scoped>
.display2left{
   width:588px;
  height: 831.6px;
  border: solid 1px;
  box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
  float: left;
  background-color: lightgreen;
}
.display2right{
   width:288px;
  height: 831.6px;
  border: solid 1px;
  float: left;
  background-color: pink;
  box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
}
</style>