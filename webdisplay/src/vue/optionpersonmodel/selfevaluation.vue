<template>
	
    
  <div id="selfevaluation">
    <div class="description">
    <label for="selfdescription">个人评价:</label><br>
    <b-form-textarea
      id="textarea"
      v-model="selfdescription"
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
   props:['selfevaluationdata'],
    data() {
      return {
        selfdescription: this.selfevaluationdata,
        // context: null
      }
    },
    watch:{
      selfdescription:function(newval){
        this.$emit('selfevaluationvalue', newval)
      }
    },
    methods: {
      
    }

    }
</script>
<style scoped>
/*#selfevaluation{
  border: 1px solid;
  padding-top: 10px;
  padding-bottom: 10px;
   margin-top:20px;
}*/
#selfevaluation #example-datepicker__outer_{
  /*display: inline-block;*/
  margin-left: 220px;
}
#selfevaluation{
 width: 80%;
  /*margin-left: 20%;*/
  height: 150px;
  /*display:inline-block;*/
  /*padding: 0.375rem 0.75rem;*/
  /*height: calc(1.5em + 0.75rem + 2px);*/

}
/*#selfevaluation .description .form-control{
   width: 660px;
    display:inline-block;
  margin-left: 20px;
  
}*/

</style>