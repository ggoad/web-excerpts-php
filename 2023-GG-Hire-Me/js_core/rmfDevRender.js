
INPTYPES.basicPk=RMFbasicInput('', '', function(){
   var v=parseInt(this.inp.value);
   if(isNaN(v) || v<=0 || v>4294967295){
      return '';
   }
	return v;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.singleLine(config));
   ret.inp.addEventListener("change", function(){
      var v=this.value;
       if(isNaN(v) || v<=0 || v>4294967295){
         return '';
       }
   });
}, 'label');
INPTYPES.string=RMFbasicInput('', '', function(){
        if(this.inp.value.length > 254){
           this.inp.value=this.inp.value.slice(0, 253);
        } 
	return this.inp.value;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.singleLine(config));
    ret.inp.addEventListener('change', function(){
        this.value=this.value.slice(0, 253);
    });
}, 'label');
INPTYPES.boolean=RMFbasicInput('', '', function(){
	return this.inp.checked;
   
}, function(v){
   this.inp.checked=parseInt(v) || 0;
}, function(config, ret){
	RMF_extractForExtension(ret,this.checkbox(config));
     ret.SET=function(v){
        this.inp.checked=!!parseInt(v);
     }
     
}, 'label');
INPTYPES.integer=RMFbasicInput('', '', function(){
   var v=parseInt(this.inp.value);
   if(isNaN(v) || v>2147483647){return '';}
	return v;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.singleLine(config));
   ret.inp.addEventListener('change', function(){
      var v=parseInt(this.value);
      if(isNaN(v) || v> 2147483647){this.value='';}
   });
}, 'label');
INPTYPES.json=RMFbasicInput('', '', function(){
       try{
         var jj=JSON.parse(this.inp.value);
       }catch(e){
         return '';
       }
	return this.inp.value;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.paragraph(config));
     ret.inp.addEventListener('change', function(){
        try{
           var jj=JSON.parse(this.value);
        }catch(e){
           this.value='';
        }
     });
}, 'label');
INPTYPES.time_stamp=RMFbasicInput('', '', function(){
   var temp=this.ts_all_inps.COLL();
   
   var ret= temp.year+"-"+temp.month+"-"+temp.day+" "+temp.hours+":"+temp.minutes+":"+temp.seconds;
   
   if(temp.microSeconds !== ''){
      ret+="."+ret.microSeconds;
   }
   if(!ret.match(/[0-9]/)){return '';}
   return ret;
   
}, function(v){
   if(!v || v === ''){return;}
   var datTim=v.split(' ');
   var datSpl=datTim[0].split('-');
   var timMic=datTim[1].split('.');
   var timSpl=timMic[0].split(':');
   this.ts_all_inps.SET({
      year:datSpl[0],
      month:datSpl[1],
      day:datSpl[2],
      hours:timSpl[0],
      minutes:timSpl[1],
      seconds:timSpl[2],
      microSeconds:timMic[1]
   });
}, function(config, ret){
   
   ret.ts_all_inps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'year',
            placeHolder:'yyyy',
            type:'singleLine'
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'month',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'day',
            placeHolder:'dd',
            type:'singleLine'
         },
         {
            type:'span',
            text:' '
         },
         {
            name:'hours',
            placeHolder:'hh',
            type:'singleLine'
         },
         {
            type:'span',
            text:':'
         },
         {
            name:'minutes',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:':'
         },
         {
            name:'seconds',
            placeHolder:'ss',
            type:'singleLine'
         },
         {
            type:'span',
            text:'.'
         },
         {
            name:'microSeconds',
            placeHolder:'------',
            type:'singleLine'
         },
       ]
   }));
   ret.el=ret.ts_all_inps.el;
   ret.inp=ret.ts_all_inps.inp;
   ret.ts_all_inps.inp.addEventListener('change', function(){
      
   });
}, 'label');
INPTYPES.float1=RMFbasicInput('', '', function(){
	return this.inp.value;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.singleLine(config));
}, 'label');
INPTYPES.date_time=RMFbasicInput('', '', function(){
   var temp=this.ts_all_inps.COLL();
   
   var ret= temp.year+"-"+temp.month+"-"+temp.day+" "+temp.hours+":"+temp.minutes+":"+temp.seconds;

   if(temp.microSeconds !== ''){
      ret+="."+ret.microSeconds;
   }
   if(ret === '-- ::'){return '';}
   return ret;
   
}, function(v){
   if(!v || v === ''){return;}
   var datTim=v.split(' ');
   var datSpl=datTim[0].split('-');
   var timMic=datTim[1].split('.');
   var timSpl=timMic[0].split(':');
   this.ts_all_inps.SET({
      year:datSpl[0],
      month:datSpl[1],
      day:datSpl[2],
      hours:timSpl[0],
      minutes:timSpl[1],
      seconds:timSpl[2],
      microSeconds:timMic[1]
   });
}, function(config, ret){
   
   ret.ts_all_inps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'year',
            placeHolder:'yyyy',
            type:'singleLine'
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'month',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'day',
            placeHolder:'dd',
            type:'singleLine'
         },
         {
            type:'span',
            text:' '
         },
         {
            name:'hours',
            placeHolder:'hh',
            type:'singleLine'
         },
         {
            type:'span',
            text:':'
         },
         {
            name:'minutes',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:':'
         },
         {
            name:'seconds',
            placeHolder:'ss',
            type:'singleLine'
         },
         {
            type:'span',
            text:'.'
         },
         {
            name:'microSeconds',
            placeHolder:'------',
            type:'singleLine'
         },
       ]
   }));
   ret.el=ret.ts_all_inps.el;
   ret.inp=ret.ts_all_inps.inp;
   ret.ts_all_inps.inp.addEventListener('change', function(){
      
   });
}, 'label');
INPTYPES.para=RMFbasicInput('', '', function(){
	return this.inp.value;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.paragraph(config));
}, 'label');
INPTYPES.enum_U_M_F_X=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"U","value":"U"},{"labelText":"M","value":"M"},{"labelText":"F","value":"F"},{"labelText":"X","value":"X"}]})));}, 'label');
INPTYPES.dollarAm=RMFbasicInput('', '', function(){
	return this.inp.value;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.singleLine(config));
}, 'label');
INPTYPES.enum_check_cash=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"check","value":"check"},{"labelText":"cash","value":"cash"}]})));}, 'label');
INPTYPES.timeOfDayCoarse=RMFbasicInput('', '', function(){
   var temp=this.tod_compound_inp.COLL();
   

   return temp.hour+":"+temp.minute+temp.amOpm;
   
}, function(v){
   v=''+v;
   var setOb={
      amOpm:"AM"
   };
   
   if(v.match("PM")){
      setOb.amOpm="PM";
   }
   
   v=v.replace(/AM|PM/, '');
   
   v=v.split(":");
   setOb.hour=v[0] || '';
   setOb.minute=v[1] || '';
   this.tod_compound_inp.SET(setOb);
}, function(config,ret){
    var hourInps=[];
    var minInps=[];
    for(var i=1; i<61; i++)
    {
        var inpV=''+i;
        var inpO={labelText:inpV, value:inpV};
        if(i<13){
           hourInps.push(inpO);
        }
        minInps.push(inpO);
    }
    ret.tod_compound_inp=this.compound({
       inps:[
          {
             type:'select',
             name:'hour',
             inps:hourInps
          },
          {type:'span','text':':'},
          {
             type:'select',
             name:'minute',
             inps:minInps
          },
          {
             type:'select',
             name:'amOpm',
             inps:[{labelText:'AM', value:'AM'},{labelText:'AM', value:'AM'}]
          },
          
       ]
    });

   ret.el=ret.tod_compound_inp.el;
   ret.inp=ret.tod_compound_inp.inp;
}, 'label');
INPTYPES.date_reg=RMFbasicInput('', '', function(){
   var temp=this.ts_all_inps.COLL();
   function padder(v){v=parseInt(v);if(v<10){return '0'+v;}return v;}
   var ret= temp.year+"-"+padder(temp.month)+"-"+padder(temp.day);


   return ret;
   
}, function(v){
   var datTim=v.split(' ');
   var datSpl=datTim[0].split('-');
   this.ts_all_inps.SET({
      year:datSpl[0],
      month:datSpl[1],
      day:datSpl[2]
   });
}, function(config, ret){
       var dt=new Date();
   
   ret.ts_all_inps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'year',
            placeHolder:'yyyy',
            type:'singleLine',
            default:dt.getFullYear()
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'month',
            placeHolder:'mm',
            type:'singleLine',
            default:dt.getMonth()+1
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'day',
            placeHolder:'dd',
            type:'singleLine',
            default:dt.getDate()
         }
       ]
   }));
   ret.el=ret.ts_all_inps.el;
   ret.inp=ret.ts_all_inps.inp;
   ret.ts_all_inps.inp.addEventListener('change', function(){
      
   });
}, 'label');
INPTYPES.date_globalContext=RMFbasicInput({
   class:'date_globalContext'
}, '', function(){
   function padder(v){if(parseInt(v) < 10){return '0'+v;}return v;}
   var temp=this.ts_all_inps.COLL();
   
   var ret= temp.year+"-"+padder(temp.month)+"-"+padder(temp.day);


   return ret;
   
}, function(v){
   var datTim=v.split(' ');
   var datSpl=datTim[0].split('-');
   this.ts_all_inps.SET({
      year:datSpl[0],
      month:datSpl[1],
      day:datSpl[2]
   });
}, function(config, ret){
   
   var dt=new Date();
   ret.ts_all_inps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'year',
            class:'RMF_year',
            placeHolder:'yyyy',
            type:'singleLine',
            default:dt.getFullYear()
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'month',
            class:'RMF_month',
            placeHolder:'mm',
            type:'singleLine',
            default:dt.getMonth()+1
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'day',
            class:'RMF_day',
            placeHolder:'dd',
            type:'singleLine',
            default:dt.getDate()
         }
       ]
   }));
   ret.el=ret.ts_all_inps.el;ret.inp=ret.ts_all_inps.inp;

   if(typeof window.RMF_globalDateContext === 'string'){
      ret.ts_all_inps.SET(window.RMF_globalDateContext);
   }

   ret.ts_all_inps.inp.addEventListener('change', function(){
      
   });
}, 'label');
INPTYPES.enum_nameOfs=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"incidental","value":"incidental"},{"labelText":"personal","value":"personal"},{"labelText":"teachingGeneral","value":"teachingGeneral"},{"labelText":"teachingLesson","value":"teachingLesson"},{"labelText":"constructionGeneral","value":"constructionGeneral"},{"labelText":"constructionJob","value":"constructionJob"}]})));}, 'label');
INPTYPES.date_timeCoarse=RMFbasicInput('', '', function(){
   function padder(v){
     if(parseInt(v) < 10){return '0'+v;}return v;
   }
   var temp=this.ts_all_inps.COLL();
   temp.hours%=12;
   if(temp.amOpm === "PM"){
      temp.hours+=12;
   }
   var ret= temp.year+"-"+padder(temp.month)+"-"+padder(temp.day)+" "+temp.hours+":"+temp.minutes+":00";

  

   return ret;
   
}, function(v){
   if(!v || v === ''){return;}
   var datTim=v.split(' ');
   var datSpl=datTim[0].split('-');
   var timSpl=(datTim[1] || '').split(':');
   var hr=parseInt(timSpl || 0);
   var amOpm="AM";
   if(hr>=12){
      amOpm = "PM";
      hr= (hr % 12) || 12;
   }
   this.ts_all_inps.SET({
      year:datSpl[0],
      month:datSpl[1],
      day:datSpl[2],
      hours:timSpl[0],
      minutes:timSpl[1],
      amopm:amOpm
   });
}, function(config, ret){
   
   ret.ts_all_inps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'year',
            placeHolder:'yyyy',
            type:'singleLine'
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'month',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'day',
            placeHolder:'dd',
            type:'singleLine'
         },
         {
            type:'span',
            text:' '
         },
         {
            name:'hours',
            placeHolder:'hh',
            type:'singleLine'
         },
         {
            type:'span',
            text:':'
         },
         {
            name:'minutes',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:' '
         },
         {
            name:'amopm',
            type:'enum_AM_PM'
         }
       ]
   }));
   ret.el=ret.ts_all_inps.el;
   ret.inp=ret.ts_all_inps.inp;
   ret.ts_all_inps.inp.addEventListener('change', function(){
      
   });
}, 'label');
INPTYPES.enum_traspoMeans=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"publicTransit","value":"publicTransit"},{"labelText":"walking","value":"walking"},{"labelText":"personalVehicle","value":"personalVehicle"},{"labelText":"otherVehicle","value":"otherVehicle"}]})));}, 'label');
INPTYPES.enum_stopEvents=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"sleep","value":"sleep"},{"labelText":"phoneCall","value":"phoneCall"},{"labelText":"textMessage","value":"textMessage"},{"labelText":"programmingTime","value":"programmingTime"},{"labelText":"expenditure","value":"expenditure"},{"labelText":"income","value":"income"},{"labelText":"lessonDelivery","value":"lessonDelivery"},{"labelText":"constructionWork","value":"constructionWork"},{"labelText":"meeting","value":"meeting"},{"labelText":"personSighting","value":"personSighting"}]})));}, 'label');
INPTYPES.enum_commuteEvents=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"phoneCall","value":"phoneCall"},{"labelText":"textMessage","value":"textMessage"},{"labelText":"personSighting","value":"personSighting"}]})));}, 'label');
INPTYPES.enum_AM_PM=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.select(_object.COMBINE(config, {inps:[{"labelText":"AM","value":"AM"},{"labelText":"PM","value":"PM"}]})));}, 'label');
INPTYPES.date_timeCoarse_globalContext=RMFbasicInput({
   class:'date_timeCoarse_globalContext'
}, '', function(){
   function padder(v){
     v=parseInt(v);
     if(v < 10){return '0'+v;}return v;
   }
   var temp=this.ts_all_inps.COLL();
   temp.hours%=12;
   if(temp.amopm === "PM"){
      temp.hours+=12;
   }
   var ret= temp.year+"-"+padder(temp.month)+"-"+padder(temp.day)+" "+temp.hours+":"+temp.minutes+":00";

  

   return ret;
   
}, function(v){
   if(!v || v === ''){return;}
   var datTim=v.split(' ');
   var datSpl=datTim[0].split('-');
   var timSpl=(datTim[1] || '').split(':');
   var hr=parseInt(timSpl[0] || 0);
   var amOpm="AM";
 // alert('ay '+hr);
   if(hr>=12){
      amOpm = "PM";
      hr= (hr % 12) || 12;
    // alert("oh");
   }
   this.ts_all_inps.SET({
      year:datSpl[0],
      month:datSpl[1],
      day:datSpl[2],
      hours:hr,
      minutes:timSpl[1],
      amopm:amOpm
   });
}, function(config, ret){

   var dt;
   if(window.RMF_globalDateContext){
      var tmp=RMF_globalDateContext.split('-');
      dt=new Date(tmp[0], tmp[1]-1, parseInt(tmp[2]) || '');
   }else{
      dt=new Date();
   }
  // alert(dt.toString());
   ret.ts_all_inps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'year',
            class:'RMF_year',
            placeHolder:'yyyy',
            type:'singleLine',
            default:dt.getFullYear()
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'month',
            class:'RMF_month',
            placeHolder:'mm',
            type:'singleLine',
            default:dt.getMonth()+1
         },
         {
            type:'span',
            text:'-'
         },
         {
            name:'day',
            class:'RMF_day',
            placeHolder:'dd',
            type:'singleLine',
            default:dt.getDate()
         },
         {
            type:'span',
            text:' '
         },
         {
            name:'hours',
            class:'RMF_hour',
            placeHolder:'hh',
            type:'singleLine'
         },
         {
            type:'span',
            text:':'
         },
         {
            class:'RMF_minute',
            name:'minutes',
            placeHolder:'mm',
            type:'singleLine'
         },
         {
            type:'span',
            text:' '
         },
         {
            name:'amopm',
            type:'enum_AM_PM'
         }
       ]
   }));
   ret.el=ret.ts_all_inps.el;
   ret.inp=ret.ts_all_inps.inp;

   
   ret.ts_all_inps.inp.addEventListener('change', function(){
      
   });
}, 'label');
INPTYPES.enum_FlatRate_Hourly=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"FlatRate","value":"FlatRate"},{"labelText":"Hourly","value":"Hourly"}]})));}, 'label');
INPTYPES.simpleAddress=RMFbasicInput('', '', function(){
   return JSON.stringify(this.simpleAddressAllInps.COLL());
}, function(v){
   if(!v || v === ''){
     return;
   }
   v=JSON.parse(v);
   this.simpleAddressAllInps.SET(v);
}, function(config, ret){
   
   ret.simpleAddressAllInps=this.compound(_object.COMBINE(config,{
       inps:[
         {
            name:'line1',
            labelText:'Line 1',
            type:'singleLine'
         },
         {
            name:'line2',
            labelText:'Line 2',
            type:'singleLine'
         },
         {
            name:'city',
            labelText:'City',
            type:'singleLine'
         },
         {
            name:'state',
            labelText:'State',
            type:'singleLine'
         },
         {
            name:'zip',
            labelText:'Zip',
            type:'singleLine'
         },
       ]
   }));
   ret.el=ret.simpleAddressAllInps.el;
   ret.inp=ret.simpleAddressAllInps.inp;
  
}, 'label');
INPTYPES.dateSingleLineFilter=RMFbasicInput('', '', function(){
   var ret=0;
   var v= this.singleLineInp.COLL();
   var vv=v.split('-');
   if(vv[2] && vv[2].length === 4 && vv[1] && vv[1].length === 2 && vv[0] && vv[0].length === 2){
      return vv[2]+'-'+vv[0]+'-'+vv[1];
   }else{return '';}
}, function(v){
   if(!v){return;}
   v=v.split('-');
   var setter='';
   if(v[2] && v[1] && v[0]){
      setter=v[1]+'-'+v[2]+'-'+v[0];
   }
   this.singleLineInp.SET(setter);
}, function(config,ret){
   var sl=this.singleLine(_object.COMBINE(config, {
     placeHolder:'mm-dd-yyyy'
   }));
   ret.singleLineInp=sl;
   ret.inp=sl.inp;
   ret.el=sl.el;
   
   ret.singleLineInp.inp.addEventListener('input', function(){
      function strSplice(str, index, count, add) {
          if (index < 0) {
            index = str.length + index;
            if (index < 0) {
               index = 0;
            }
          }
  
          return str.slice(0, index) + (add || "") + str.slice(index + count);
      }
      var firstInsterted=false;
      var secondInserted=false;
      var n='n', d='-';
      var order=[n,n,d,n,n,d,n,n,n,n];
      var j=this.selectionStart;
      var v=this.value;
      v=v.replace(/[^0-9\-]/,'');
     
      //debugger;
      for(var i=0; i<v.length && i<order.length; i++)
      {
         
              // console.log(i,v);
         if(v.charAt(i).match(/[0-9]/)){
            if(order[i] === n){
               continue;
            }else{
               
               v=strSplice(v,i, 0, d);
               v=v.replace('--','-');
               if(i === 2){
                  v=v.replace(/([0-9]+\-[0-9]+)\-([0-9]+\-[0-9]+)/,'$1$2');
               }else{
                  v=v.replace(/([0-9]+\-[0-9]+\-[0-9]+)\-([0-9]+)/,'$1$2')
               }
               if(i<=j){j++;}
               i++;
              // console.log('insertDash');
            }
         }else if(v.charAt(i).match('-')){
            if(order[i] === d){
               continue;
            }else if(i === 1 || i === 4){
               v=strSplice(v,i-1,0,'0');
               if(i<= j){j++;}
               i++;
               //console.log('padZero')
            }else{
               v=strSplice(v,i,1);

               if(i<=j){j--;}i--;
              // console.log('take out dash')
            }
         }
      }
      v=v.slice(0, order.length);
      this.value=v;
      this.selectionStart=this.selectionEnd=j;
   });
}, 'label');
INPTYPES.timeSingleLineFilter=RMFbasicInput('', '', function(){
   var sl=this.singleLineInp.value;
   var amOpm=this.selectInp.options[this.selectInp.selectedIndex].value;
   
   var hr, min;

   sl=sl.split(':');
   if(!sl[0] || !sl[1]){
     return '';
   }
   hr=sl[0]; min=sl[1];
   if(sl[0] === '12'){
         hr='00';
      
   }
   if(amOpm === 'PM'){
      hr=parseInt(hr)+12;
      hr=''+hr;
      if(hr.length < 2){hr='0'+hr;}
   }
   
   return hr+':'+sl[1];
}, function(v){
   v=v.split(':');
   if(!v[0] || !v[1]){
      this.singleLineInp.value='';
      return;
   }
   var hr=v[0], min=v[1], amOpm='AM';
   var hrint=0;
   if(v[0] === '00'){
      hr='12';
      
   }
   hrint=parseInt(v[0]);
   
   this.selectInp.selectedIndex=0;
   if(hrint >= 12){

     this.selectInp.selectedIndex=1;
     amOpm='PM';
     hr=''+((hrint-12) || 12) ;
     if(hr.length < 2){hr='0'+hr;}
   }
   this.singleLineInp.value=(hr+":"+min);
   
   //this.selectInp.selectedIndex=(Array.from(this.selectInp.options).find(function(a){return a.value===amOpm;})||{}).value || 0;
}, function(config, ret){
    var el=_el.CREATE('div');
    var select=_el.CREATE('select','','',{
       
    },[
       _el.CREATE('option','','',{value:'AM'},[_el.TEXT('AM')]),
       _el.CREATE('option','','',{value:'PM'},[_el.TEXT('PM')])
    ]);
    var singleLine=_el.CREATE('input','','',{
       placeholder:'hh:mm'
    });
    singleLine.addEventListener('input', function(){
      function strSplice(str, index, count, add) {
          if (index < 0) {
            index = str.length + index;
            if (index < 0) {
               index = 0;
            }
          }
  
          return str.slice(0, index) + (add || "") + str.slice(index + count);
      }
       var v=this.value;

       var j=this.selectionStart;

       
       
       for(var i=0; i<v.length; i++)
       {
          if(v.charAt(i).match(/[^0-9]/)){
             v=strSplice(v,i,1);
             if(i<j){
                j--;
             }i--;
          }
       }
       if(v.length > 4){
          v=strSplice(v,j,v.length-4);
       }

       if(v.length > 2){
          v=strSplice(v,v.length-2,0,':');
          if(j>= v.length-3){
             j++;
          }
       }
      // console.log('first',v);
       if(v.length === 4){
           v=strSplice(v,0,0,'0');
           j++;
       }

      // console.log('second',v);
   
       j=Math.min(j, 5);
       v=v.slice(-5);
       this.value=v;
       this.selectionStart=this.selectionEnd=j;
    }); 

    _el.APPEND(el,[singleLine, select]);
    ret.selectInp=select;
    ret.singleLineInp=singleLine;
    ret.inp=ret.el=el;
}, 'label');
INPTYPES.GeoCoor=RMFbasicInput('', '', function(){
        if(this.inp.value.length > 254){
           this.inp.value=this.inp.value.slice(0, 253);
        } 
	return this.inp.value;
}, '', function(config, ret){
	RMF_extractForExtension(ret,this.singleLine(config));
    ret.inp.addEventListener('change', function(){
       
    });
}, 'label');
INPTYPES.dateTimeSingleLineFilter=RMFbasicInput('', '', function(){
   var coll=this.dt_sf_allInps.COLL();
   return coll.date+' '+coll.time;
}, function(v){
   var spl=v.split(' ');
   if(spl){
      this.dt_sf_allInps.SET({date:spl[0],time:spl[1]});
   }
}, function(config,ret){
   ret.dt_sf_allInps=this.compound(_ob.COMBINE(config,{
      inps:[
         {type:'dateSingleLineFilter',name:'date'},
         {type:'timeSingleLineFilter',name:'time'}
      ]
   }));
   ret.inp=ret.dt_sf_allInps.inp;
   ret.el=ret.dt_sf_allInps.el;
}, 'label');
INPTYPES.enum_pickup_dropoff=RMFbasicInput('', '', function(){return this.EXT_OLDCOL();}, '', function(config, ret){RMF_extractForExtension(ret,this.radioFamily(_object.COMBINE(config, {inps:[{"labelText":"pickup","value":"pickup"},{"labelText":"dropoff","value":"dropoff"}]})));}, 'label');

var RMFTYPEPKS={"basicPk":"4","boolean":"6","dateSingleLineFilter":"104","dateTimeSingleLineFilter":"136","date_globalContext":"38","date_reg":"37","date_time":"11","date_timeCoarse":"46","date_timeCoarse_globalContext":"69","dollarAm":"20","enum_AM_PM":"62","enum_check_cash":"22","enum_commuteEvents":"51","enum_FlatRate_Hourly":"78","enum_nameOfs":"44","enum_pickup_dropoff":"144","enum_stopEvents":"50","enum_traspoMeans":"47","enum_U_M_F_X":"16","float1":"10","GeoCoor":"132","integer":"7","json":"8","para":"12","simpleAddress":"96","string":"5","timeOfDayCoarse":"33","timeSingleLineFilter":"105","time_stamp":"9"}
var RMFTYPENAMES={"4":"basicPk","6":"boolean","104":"dateSingleLineFilter","136":"dateTimeSingleLineFilter","38":"date_globalContext","37":"date_reg","11":"date_time","46":"date_timeCoarse","69":"date_timeCoarse_globalContext","20":"dollarAm","62":"enum_AM_PM","22":"enum_check_cash","51":"enum_commuteEvents","78":"enum_FlatRate_Hourly","44":"enum_nameOfs","144":"enum_pickup_dropoff","50":"enum_stopEvents","47":"enum_traspoMeans","16":"enum_U_M_F_X","10":"float1","132":"GeoCoor","7":"integer","8":"json","12":"para","96":"simpleAddress","5":"string","33":"timeOfDayCoarse","105":"timeSingleLineFilter","9":"time_stamp"}
