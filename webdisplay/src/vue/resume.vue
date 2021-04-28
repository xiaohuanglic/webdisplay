<template>
	 <forestage ref="child"></forestage>

</template>
<script>
import forestage from './forestage .vue'
import axios from "axios";
import personcomponent from './person/personcomponent.vue'
import Vue from 'vue'
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    
        components: {forestage,personcomponent},
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
          this.creatpersonpage(taskid)
        
           
           
          
        },
        watch:{
            $route(to,from){
            
          }
        },

        methods:{
          creatpersonpage(value){
               var html ='<div><personcomponent :taskid="taskid"></personcomponent></div>'
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
                    

                   },
                 

                })
                new addpersonal().$mount('#change')
          },
        
        }
      
      }

</script>
<style>


</style>
<!-- <div class="checkbox" ><div v-for="(value, key, index) in promoney"><label class="moneytext">{{key}}:{{value}}</label><input type="checkbox" v-model="whom" v-bind:value="key+space+value"  @click="chooseActivity(index)"/></div></div> -->
<!-- <input type="button" @click=order() value="付款"/> -->
<!-- <a :href=item class="pichref"></a> -->