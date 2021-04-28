 import axios from "axios";
 import Vue from 'vue';
import qs from 'qs'
 axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
 var usernamelist = [];
 var getuser ={
    "getnewnum":usernamelist
};
function setusername(usernamelist){
    getuser['getnewnum'] = usernamelist;
}
 if(sessionStorage.getItem("vue-session-key")!=null){
    var sessionid = JSON.parse(sessionStorage.getItem("vue-session-key"))['session-id']
    axios.post('http://localhost:5001/checksession.php',{sessionid:sessionid}).then(res=>{
     var myid = res.data['userid'];
     axios.get('http://localhost:5001/gettotalnum.php/?myid='+myid).then(res=>{
        usernamelist = [];
            for(var i = 0;i<res.data.length;i++){
                if(myid==res.data[i]['myid']){
                                
                    usernamelist.push({chatid:res.data[i]["chatid"],username:res.data[i]["username"],userid:res.data[i]["userid"],usernum:res.data[i]["usernum"]});

                }else if(myid==res.data[i]['userid']){
                    usernamelist.push({chatid:res.data[i]["chatid"],username:res.data[i]["myname"],userid:res.data[i]["userid"],usernum:res.data[i]["mynum"]});
                    }
                   
                }
                setusername(usernamelist);
     })

    })
 }
 
 

 


export default getuser