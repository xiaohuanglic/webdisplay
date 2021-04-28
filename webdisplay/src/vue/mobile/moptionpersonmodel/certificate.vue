<template>
 
    
    <div id="certificate">
    <div class="description">
    <label for="certdescription">证书奖励:</label><br>
    <b-form-textarea size="sm"
      id="textarea"
      v-model="certdescription"
      placeholder="Enter something..."
      rows="4"
      max-rows="6"
      ></b-form-textarea>
    </div>
    
    </div>
  
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    props:['certificatedata'],
    data() {
      return {
        certdescription: this.certificatedata,
        // context: null
      }
    },
    watch:{
      certdescription:function(newval){
        this.$emit('certificatevalue', newval)
      }
    },
    methods: {
      
    }

    }
</script>
<style scoped>
/*#certificate{
  border: 1px solid;
   padding-top: 10px;
  padding-bottom: 10px;
   margin-top:20px;
}*/
#certificate #example-datepicker__outer_{
  /*display: inline-block;*/
  margin-left: 20%;
}
#certificate{
 
  height: 150px;
  /*display:inline-block;*/
  /*padding: 0.375rem 0.75rem;*/
  /*height: calc(1.5em + 0.75rem + 2px);*/

}
/*#certificate .description .form-control{
   width: 80%;
    display:inline-block;
  margin-left: 20%;
 
}*/
</style>