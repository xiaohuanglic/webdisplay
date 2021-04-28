<template>
	<div>
	  <!--1.首先要填入邮箱，判断邮箱存在不存在 
        2.如果邮箱存在，就发送邮箱地址，转到重新填写用户密码-->
      <label for="username">邮箱:</label>
      <input type="text" id="email" v-model="email"><br><br>
      <!-- <button @click="submit">发送邮箱</button> -->
    
	</div>
</template>
<script>
import axios from "axios";
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
export default {
    data() {
      return{
        email:''
        }
      },
    methods:{
        submit(){
            console.log("发送到邮箱")
        }
    }

    }
</script>
<style scoped>
 
</style>