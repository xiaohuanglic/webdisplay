<template>
    <div >

          <label for="getsalary">工资:</label>
         <div id="getsalary">
   
          <b-form-select v-model="getsalary" :options="salaryoptions" size="sm" class="mt-3"></b-form-select>
          </div>
         <label for="geteducation">学历:</label>
         <div id="geteducation">
   
          <b-form-select v-model="geteducation" :options="edcoptions" size="sm" class="mt-3"></b-form-select>
          </div>
        <label for="getexperiencerequirement">经验要求:</label>
         <div id="getexperiencerequirement">
   
          <b-form-select v-model="getexperiencerequirement" :options="options" size="sm" class="mt-3"></b-form-select>
          </div>
         
       
     </div>
 
    
  </div>
</template>
<script>
import axios from "axios";

// import selfevaluation from './optionpersonmodel/selfevaluation.vue';
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    props:['getexperiencerequirement','geteducation','getsalary'],
    components: {
    
          
    },
    data() {
      return {
        getsalary:this.getsalary,
        salaryoptions: [
          { value: '面谈', text: '面谈' },
          { value: '3千以下', text: '3千以下' },
          { value: '3千-5千', text: '3千-5千' },
          { value: '5千-7千', text: '5千-7千'},
          { value: '7千-9千', text: '7千-9千' },
          { value: '9千-1万', text: '9千-1万' },
          { value: '1万以上', text: '1万以上' }
        ],
        getexperiencerequirement:this.getexperiencerequirement,
        options: [
          { value: '无要求', text: '无要求' },
          { value: '应届毕业生', text: '应届毕业生' },
          { value: '1-3年', text: '1-3年' },
          { value: '3-5年', text: '3-5年'},
          { value: '5年以上', text: '5年以上' }
        ],
        geteducation:this.geteducation,
        edcoptions: [
          { value: '无要求', text: '无要求' },
          { value: '高中', text: '高中' },
          { value: '大专', text: '大专' },
          { value: '本科', text: '本科'},
          { value: '硕士', text: '硕士' },
          { value: '硕士以上', text: '硕士以上' }
        ],
       

      }
    },
    mounted(){
        console.log(this.getexperiencerequirement)
    },
    watch:{
      getexperiencerequirement:function(value){
        this.$emit('experiencerequirement', value);
      },
      geteducation:function(value){
        this.$emit('education', value);
      },
      getsalary:function(value){
        this.$emit('salary', value);
      },

    },
    methods: {
     

      // onContext(ctx) {
      //   this.context = ctx
      // }
    }

    }
</script>
<style scoped>
#geteducation{
    margin-left: 25%;
    width: 70%;
}
#getexperiencerequirement{
    margin-left: 25%;
    width: 70%;
}
#getsalary{
  margin-left: 25%;
    width: 70%;
}
</style>