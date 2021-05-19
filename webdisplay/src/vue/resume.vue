<template>
	 <forestage ref="child"></forestage>

</template>
<script>
import forestage from './forestage .vue'
import success from './success.vue'
import axios from "axios";
import personcomponent from './person/personcomponent.vue'
import Vue from 'vue'
import url from "../js/totalurl.js";
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    
        components: {forestage,personcomponent,success},
        data() {
          return{
            id:'',
            resdata:{},
            getdata:'',
            proimage:[],
          }
        
        },
        mounted: function () {
        	// var userid = JSON.parse(sessionStorage.getItem("vue-session-key"))['username'][1]
        	var taskid = this.$route.query.taskid
          var that = this;
          this.creatpersonpage(taskid,that)
        
           
           
          
        },
        watch:{
            $route(to,from){
            
          }
        },

        methods:{
          creatsuccess(that){
             var html ='<div><success></success></div>'
                  var addsuccess = Vue.extend({
                  template: html,
                   components: {success},
                  data() {
                    return{
                        taskid:value,
                   
                      }
                  },
                  watch:{
                  
                  },
                   mounted() {
                     
                     
                      

                      
                   },
                   methods:{


                   },
                 

                })
                new addsuccess().$mount('#change')
          },
          creatpersonpage(value,that){
               var html ='<div><personcomponent :taskid="taskid" v-on:ongetchoose="ongetchoose"></personcomponent></div>'
                  var addpersonal = Vue.extend({
                  template: html,
                   components: {personcomponent},
                  data() {
                    return{
                        taskid:value,
                   
                      }
                  },
                  watch:{
                  
                  },
                   mounted() {
                     
                     
                      

                      
                   },
                   methods:{
                    ongetchoose(resume){
                       
                       axios.post(url+'/resume.php',{resume:resume}).then(res=>{
                              console.log(res.data);
                              // 转跳页面
                             
                          })
                       var child = that.$refs.child
                       child.clearchange(child);
                       that.creatsuccess();
                    }

                   },
                 

                })
                new addpersonal().$mount('#change')
          },
        
        }
      
      }

</script>
<style>


</style>
