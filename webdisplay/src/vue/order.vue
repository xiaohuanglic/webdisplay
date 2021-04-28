<template>
	 <forestage></forestage>
</template>
<script>
import forestage from './forestage .vue'
import axios from "axios";
import Vue from 'vue';
import qs from 'qs';
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
   
export default {
    
    components: {forestage},
    data(){
                return{
                orderid:"",
                ordername:"",
                orderintro:"",
                userid:"",
                taskid:"",
                myid:"",
                orderprice:"",
                ordertime:"",
                date:"",
              }
            },
    
    mounted: function () {
      // new addimage().$mount('#change')
      var that = this;
      var addimage=Vue.extend({
           
            template:'<div><table border="1" cellspacing="0"><tr><th v-if="seen" v-for="(item, index) in tdname">{{item}}</th></tr><tr><td v-if="seen" v-for="(item, index) in td">{{item}}</td><td v-if="seen"><a @click="getorder">确认购买</a></td></tr></table><p v-if="!seen">请输入正确的数据</p></div>',
             data(){
                return{
                tdname:["名称","介绍","天数","价格","付款"],
                td:["ordername","orderintro","ordertime","orderprice"],
                seen:false,
              }
            },
            mounted: function () {
              that.myid = that.$route.query.myid;
              that.userid = that.$route.query.userid;
              if(that.$route.query.personid!=null){
              that.personid = that.$route.query.personid;
              }else if(that.$route.query.taskid!=null){
              that.taskid = that.$route.query.taskid;
              }
              axios.post('http://localhost:5001/order.php',{userid:that.userid,myid:that.myid,personid:that.personid,taskid:that.taskid}).then(res=>{
                    
                    that.ordername = res.data.personname;
                    that.orderintro = res.data.personinfo;
                    var moneydata = res.data.personmoney;
                    
                    moneydata = moneydata.replaceAll(":",'":"')
                    moneydata = moneydata.replaceAll("{",'{"')
                    moneydata = moneydata.replaceAll("}",'"}')
                    moneydata = moneydata.replaceAll(",",'","')
                    
                    moneydata = JSON.parse(moneydata);
                    if(that.$route.query.promoney!=null){
                        if(that.$route.query.promoney.indexOf("1个月")!=-1){
                            if(moneydata.one!=null){
                              that.ordertime = 1*30;
                              that.orderprice = moneydata.one;
                          }

                        }else if(that.$route.query.promoney.indexOf("3个月")!=-1){
                           if(moneydata.three!=null){
                            that.ordertime = 3*30;
                            that.orderprice = moneydata.three;
                      
                          }

                        }else if(that.$route.query.promoney.indexOf("6个月")!=-1){
                            if(moneydata.six!=null){
                            that.ordertime = 6*30;
                            that.orderprice = moneydata.six;
                      
                        }else{
                            that.ordertime ="";
                            that.orderprice = "";
                        }

                      }
                    }else{
                        that.ordertime ="";
                        that.orderprice = "";
                    }
                    for(var i = 0;i<this.td.length;i++){
                      if(this.td[i]=="ordername"){
                        this.td[i] = that.ordername;
                      }

                     if(this.td[i]=="orderintro"){
                        this.td[i] = that.orderintro;
                      }

                      if(this.td[i]=="ordertime"){
                        this.td[i] = that.ordertime;
                        if(this.td[i]==""){
                          this.seen=false;
                        }
                      }
                      if(this.td[i]=="orderprice"){
                        this.td[i] = that.orderprice;
                        if(this.td[i]==""){
                          this.seen=false;
                        }else{
                          this.seen = true;
                        }
                      }
                     
                     
                    }                
                   // this.seen=true;
              })

            },
            methods:{
                getFormatDate() {
                var date = new Date();
                var month = date.getMonth() + 1;
                var strDate = date.getDate();
                if (month >= 1 && month <= 9) {
                  month = "0" + month;
                }
                if (strDate >= 0 && strDate <= 9) {
                  strDate = "0" + strDate;
                }
                var currentDate = date.getFullYear() + "-" + month + "-" + strDate
                  + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                  return currentDate
                },
                getorder(){
                  that.date = this.getFormatDate();
                   axios.post('http://localhost:5001/getorder.php',{sellerid:that.userid,buyerid:that.myid,personid:that.personid,taskid:that.taskid,paymentdate:that.date,paymoney:that.orderprice,payday:that.ordertime}).then(res=>{
                      console.log(res.data);
                   })
                   // console.log(that.date)
                 //假如购买成功的代码

                  // that.$router.push({
                  //   path: '/boss'
                  // })
                }
            }
           
          
          
        })
       
     
        new addimage().$mount('#change')
            
   }
        
        
        
}
       

</script>
<style>


</style>
