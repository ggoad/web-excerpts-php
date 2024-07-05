<?php 
require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/admin/onlyLoggedOut.php");


?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="robots" content="noindex|nofollow"/>
<title>Password Recovery | Demo Greg Goad Dot Net</title>

<meta name="description" content="Demo Greg Goad Dot Net Generate Password Reset"/>
<link rel="apple-touch-icon" sizes="180x180" href="/adminTest/appMedia/icons/regalG/180.png" />
<link rel="apple-touch-icon" sizes="152x152" href="/adminTest/appMedia/icons/regalG/152.png" />
<link rel="apple-touch-icon" sizes="120x120" href="/adminTest/appMedia/icons/regalG/120.png" />
<link rel="icon" sizes="16x16" href="/adminTest/appMedia/icons/regalG/16.png" />
<link rel="icon" sizes="32x32" href="/adminTest/appMedia/icons/regalG/32.png" />
<link rel="icon" sizes="57x57" href="/adminTest/appMedia/icons/regalG/57.png" />
<link rel="icon" sizes="76x76" href="/adminTest/appMedia/icons/regalG/76.png" />
<link rel="icon" sizes="96x96" href="/adminTest/appMedia/icons/regalG/96.png" />
<link rel="icon" sizes="120x120" href="/adminTest/appMedia/icons/regalG/120.png" />
<link rel="icon" sizes="128x128" href="/adminTest/appMedia/icons/regalG/128.png" />
<link rel="icon" sizes="144x144" href="/adminTest/appMedia/icons/regalG/144.png" />
<link rel="icon" sizes="152x152" href="/adminTest/appMedia/icons/regalG/152.png" />
<link rel="icon" sizes="167x167" href="/adminTest/appMedia/icons/regalG/167.png" />
<link rel="icon" sizes="180x180" href="/adminTest/appMedia/icons/regalG/180.png" />
<link rel="icon" sizes="192x192" href="/adminTest/appMedia/icons/regalG/192.png" />
<link rel="icon" sizes="195x195" href="/adminTest/appMedia/icons/regalG/195.png" />
<link rel="icon" sizes="196x196" href="/adminTest/appMedia/icons/regalG/196.png" />
<link rel="icon" sizes="228x228" href="/adminTest/appMedia/icons/regalG/228.png" />
<link rel="shortcut icon" sizes="196x196" href="/adminTest/appMedia/icons/regalG/196.png" />
<meta name="msapplication-TileImage" content="/adminTest/appMedia/icons/regalG/144.png" />
<meta property="og:image" content="/adminTest/appMedia/images/Mochobo/source.png" />
<meta property="og:image:alt" content="This is Crazy" />

<script>/* START _element */
_el={
	/* cancel an event */
    CancelEvent:function(e){e.preventDefault(); e.cancelBubble=true;},
	/* move an id from 1 element to another */
    MoveId:function(id,el){
       (document.getElementById(id) || {}).id='';
       el.id=id;
    },
	/* this is a helper for CREATE */
    PARSE_element:function(a){
       if(typeof a === "string"){return this.TEXT(a);}
       return a;
    },
	/* remove an element */
	REMOVE:function(e){
		if(e && e.parentNode){e.parentNode.removeChild(e);}
	},
	/* append an element to a parent, returns the parent */
	APPEND:function(p,c){
		if(Array.isArray(c)){
			for(var i=0; i<c.length; i++)
			{
				p.appendChild(this.PARSE_element(c[i]));
			}
		}else{
			p.appendChild(this.PARSE_element(c));
		}
		return p;
	},
	/* append an element to a parent, returns the child */
	_APPEND:function(p,c){
		if(Array.isArray(c)){
		   c.forEach(function(a){p.appendChild(_el.PARSE_element(c));});
		}else{p.appendChild(this.PARSE_element(c));}
			

		return c;
	},
	/* 
		create an element: 
			tp is the tag name 
			id is id
			className is className 
			otherMemOb 
				is anything to insert as a property on the element
				two special properties:
					'style'
						and
					'attributes'
			append 
				an array of elements to append to the created element
				raw strings are created as text nodes
	*/
	CREATE:function(tp, id, className, otherMemOb, append){
		var ret=document.createElement(tp);
		if(id){
			ret.id=id;
		}
		if(className){
			ret.className=className;
		}
		if(otherMemOb){
			for(var mem in otherMemOb)
			{
				if(mem === "style"){
					for(var s in otherMemOb[mem])
					{
						ret.style[s]=otherMemOb[mem][s];
					}
				}else if(mem === 'attributes'){
					for(var a in otherMemOb[mem]){ret.setAttribute(a, otherMemOb[mem][a]);}
				}else{
					ret[mem]=otherMemOb[mem];
				}
			}
		}
		if(append){
		   this.APPEND(ret, append);
		}
		return ret;
	},
	/* create a text node */
	TEXT:function(txt){
		return document.createTextNode(txt);
	},
	/* removes all child elements */
	EMPTY:function(el){
		if(el && el.childNodes){
			for(var i=0; i<el.childNodes.length; i++)
			{
				if(el.childNodes[i]){
					el.removeChild(el.childNodes[i]);
					i--;
				}
			}
		}
	}
};


/* END _element */
// START _object
_ob=_object={
        COPY_proto:(function(){
	  function Temp(){}
	    return function(O){
	      if(typeof O != "object"){
		throw TypeError("Object prototype may only be an Object or null");
	      }
		Temp.prototype=O;
		var obj=new Temp();
		Temp.prototype=null;
	      return obj;
	   }
	})(),
	IS_array:function(a){
		if(Array.isArray && Array.isArray(a)){
                   return true;
                }if(typeof a === "object" && a.constructor === Array){
			return true;
		}return false;
	},
	IndexedObject:function(arr){
		this._enum=[];
		this._map={};
		this.length=0;
		if(_ob.IS_array(arr)){
			for(var i=0; i<arr.length; i++)
			{
				this.PUSH(arr[i]);
			}
		}
	},
	COMBINE:function(ob1, ob2){
		ob1=ob1 || {};
		ob2=ob2 || {};
		var ret={};
		this.INSERT(ret, ob1);
		this.INSERT(ret, ob2);
		return ret;
	},
	INSERT:function(reciever, con){
		con = con || {};
		for(var mem in con)
		{
			reciever[mem]=con[mem];
		}
	},
        PARSE_default:function(def,set){
           return this.COMBINE(def,set);
        },
        Keysort:function(obj, recur, depth){
           depth=depth || 0;
           depth++;
           var ordered=Object.keys(obj).sort().reduce(function(o,key){
              if(recur && typeof obj[key] === "object" && depth < 10){
                 obj[key]=this.Keysort(obj[key], true, depth);
              }
              o[key]=obj[key];
              return o;
           });
           return ordered;
        },
        COMPARE:function(ob1, ob2){
            if(typeof ob1 !== "object" || typeof ob2 !== "object"){return false;}
            if(Object.keys(ob1).length !== Object.keys(ob2).length){return false;}
            var cmp=true;
            for(var mem in ob1)
            {
               if(typeof ob1[mem] === "object"){
                  cmp=this.COMPARE(ob1[mem], ob2[mem]);
               }else{
                  cmp=(ob1[mem] === ob2[mem]);
               }
               if(!cmp){return false;}
            }
            return true;
        },
        CLONE_depthLimit:20,
	CLONE:(function(){
		return function(obj, depth, callDepth){
			depth=depth || 1;
			callDepth=callDepth || 0;
			if(depth === -1){
				depth = this.CLONE_depthLimit;
				if(callDepth === this.CLONE_depthLimit){
					throw new TypeError("Depth limit reached: ", obj);
					return obj;
				}
			}
			
			if((obj === null || typeof obj !== "object") || (callDepth === depth || callDepth === this.CLONE_depthLimit)){
				return obj;
			}
			if(obj instanceof Date){
				return new Date(obj.getTime());
			}
			if(this.IS_array(obj)){
				var retArr=[];
				for(var i=0; i<obj.length; i++)
				{
					
					retArr[i]=this.CLONE(obj[i], depth, callDepth+1);
				}
				return retArr;
			}
			
			if(obj.CLONE){
				return obj.CLONE();
			}
			var ret={};
			for(var mem in obj)
			{
				if(obj.hasOwnProperty(mem)){
					ret[mem]=this.CLONE(obj[mem], depth, callDepth+1);
				}
			}
			return ret;
		}
	})()
};

_ob.IndexedObject.prototype.PUSH=function(a){
	var ret=this._enum.length;
	this._map[a]=this._enum.length;
	this._enum.push(a);
	this.length++;
	return ret;
}
_ob.IndexedObject.prototype.GET_nameSafe=function(a){
    a=parseInt(a);
    if(!isNaN(a) && a>=0 && a<this.length){
       return this._enum[a];
    }return false;
}
_ob.IndexedObject.prototype.GET_name=function(a){
	a=parseInt(a);
	if(!isNaN(a) && a>=0 && a<this.length ){
		return this._enum[a];
	}throw new TypeError("Not a number, or out of range");
}
_ob.IndexedObject.prototype.GET_numSafe=function(a){
   a=""+a;
   if(typeof this._map[a] !== "undefined"){
      return this._map[a];
   }return false;
}
_ob.IndexedObject.prototype.GET_num=function(a){
	a=""+a;
	if(typeof this._map[a] !== "undefined"){
		return this._map[a];
	}throw new TypeError("Not a valid member: "+a);
}
_ob.IndexedObject.prototype.GET_names=function(a){
   return this._enum;
}
// END _object
function DUMMY_FUNCT(){}
_fun={
	curryScope:function(fun,scp){
		return function(){
			fun.apply(scp,arguments);
		}
	},
	curryArgs:function(fun, arg){
                if(!Array.isArray(arg)){throw new TypeError('Arg must be an array');}
		return function(){
			fun.apply({}, arg);
		}
	},
	curryScopeArgs:function(fun,scp,arg){
                if(!Array.isArray(arg)){throw new TypeError('Arg must be an array');}
		return function(){
			fun.apply(scp,arg);
		}
	},
	Que:function(keep, fArr){
		this.arr=[];
		this.it=-1;
		this.keep=!!keep;
		this.paused=true;
		if(Array.isArray(fArr)){
			for(var i=0; i<fArr.length; i++)
			{
				if(typeof fArr[i] === "function"){
					this.ADD(fArr[i]);
				}else{
					throw new TypeError("A member of fArr was not a function.", fArr, i);
				}
			}
		}
	}
};
_fun.Que.prototype.CLONE=function(){
	return new _fun.Que(this.keep,this.arr);
};
_fun.Que.prototype.RUN=function(a){
	if(this.paused){
		this.paused=false;
		var k;
		while(this.paused===false && this.it >= 0)
		{
			if(this.keep){
				k=this.arr[this.it];
			}else{
				k=this.arr.pop();
			}
			this.it--;
			k(this);
			if(this.paused==true){
				if(a){
					a.PAUSE();
					this.a=a;
					return;
				}
			}
		}
		if(this.it === -1){
			this.paused=true;
			if(this.keep){
				this.it=this.arr.length-1;
			}
			if(a){
				a.RESUME();
			}
		}
	}else{
		this.CLONE().RUN(a);
	}
};
_fun.Que.prototype.CLEAR=function(){
	this.arr=[];
	this.it=-1;
	this.paused=true;
};
_fun.Que.prototype.ADD=function(f){
	var fir;
	if(Array.isArray(f)){
		fir=f;
	}else if(typeof f === "function"){
		fir=[f];
	}else{
		throw new TypeError("Not a valid type: function que");
	}
	this.arr=fir.concat(this.arr);
	this.it++;
	return this.it;
};
_fun.Que.prototype.POP=function(){
	this.it--;
	return this.arr.pop();
};
_fun.Que.prototype.PAUSE=function(a){
	this.paused=true;
	if(a){
		this.a=a;
	}
};
_fun.Que.prototype.RESUME=function(){
	var a=this.a;
	this.a=undefined;
	setTimeout(_fun.curryScopeArgs(this.RUN,this,[a]), 1);
};
function ElFetch( target,fetchMessage, file, config, responseType,responseHandlers,disablers){
    /*
      target: element to be the target,
      fetchMessage: a node to be appended to the target, 
     
         file:string, 
         config (the config of the actual call to fetch): {body:string, method:'POST', etc...}, 
         responseType: string json | text 
    */
    /* responseHandlers ={
         success: function(result, target){} to be fired on success
         fail: function(error, target){} to be fired on failure,
         overrideMsg: if you only want to display a single message on failure
       }
    */
    config=config || {};
    disablers=disablers || {};
    if(disablers.button){
       disablers.button.setAttribute('disabled','');
    }else if(disablers.form){
       var oldListener=disablers.form.onsubmit;
       disablers.form.onsubmit=function(e){
            e.stopImmediatePropagation();
            e.preventDefault();
            e.cancelBubble=true;
       }
    }else if(disablers.fieldset){
       disablers.fieldset.setAttribute('disabled','');
    }
    if(typeof fetchMessage === 'string'){fetchMessage=_el.TEXT(fetchMessage);}
    _el.APPEND(target, fetchMessage);
    fetch(file,config)
    .then(function(res){
        _el.REMOVE(fetchMessage);
        console.log("fetchResult:",res, res.status);
        if(parseInt(res.status) >= 400){
            console.log(file+" errorStatus: "+res.status);
            throw new Error("Server Error "+res.status);
        }
        return res[responseType]();
    }).then(function(rt){
        if(disablers.button){
           disablers.button.removeAttribute('disabled');
        }else if(disablers.form){
           disablers.form.onsubmit=oldListener;
        }else if(disablers.fieldset){
           disablers.fieldset.removeAttribute('disabled');
        }
        if((responseType === 'json' &&  rt.success) || rt === "SUCCESS"){
            _el.REMOVE(fetchMessage);
            responseHandlers.success(rt,target);
        }else{
            console.log('error', rt);
            var err= new Error(responseHandlers.overrideMsg || "Error Processing: "+((responseType === "json") ? (rt.msg || '') : rt || ''));
            err.dat=rt;
            throw err;
        }
        
    }).catch(function(e){
        _el.REMOVE(fetchMessage);
        if(disablers.button){
           disablers.button.removeAttribute('disabled');
        }else if(disablers.form){
           disablers.form.onsubmit=oldListener;
        }else if(disablers.fieldset){
           disablers.fieldset.removeAttribute('disabled');
        }
        console.log(e, e.dat || '');
        if(responseHandlers.fail){
           setTimeout(responseHandlers.fail(e,target), 1);
        }
        _el.REMOVE(fetchMessage);
        var m=e.message;
        if(e.message === 'Failed to fetch'){
            m=("There was a problem submitting. Possibly a network error. Please try again.");
        }
        console.log(file+" Fetch Error: "+m);
		if(!responseHandlers.quietError){
			_el.APPEND(target, m);
		}
    });
}</script>

<style>#waitDiv{
	position:fixed;
	bottom:0;
	left:0;
	width:100%;
	padding:8px;
	padding-bottom:12px;
	box-sizing:border-box;
}
.info{
	background-color:tan;
} 
.error{
	border:4px solid red;
	background-color:pink;
}
#waitDiv:empty{
	padding:0;
}
*{text-align:center;}
form{
	display:inline-block;
	width:80%;
	padding:8px;
	margin-top:50px;
	margin-bottom:150px;
	max-width:500px;
	background-color:lightBlue;
	border:3px solid orange;
	box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.2);
	
	
}
label{
	display:block;
	margin-top:10px;
	margin-bottom:10px;
}
input{
	margin:8px;
}

@keyframes spin {
  0% {
    transform: rotateY(0deg);
  }
  100% {
    transform: rotateY(360deg);
  }
}

#SpinLeft {
	display:inline-block;
  animation: spin 1s infinite;
}
#SpinRight {
	display:inline-block;
  animation: spin 1s infinite;
  animation-direction:reverse;
}

#forgotPasswordLink {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-width: 4px;
  border-style: outset;
  border-color: #0056b3;
  border-radius: 5px;
  cursor: pointer;
  transition: border-color 0.2s;
  float:right;
  margin-top:15px;
}

#forgotPasswordLink:hover {
  border-color: #003f7e;
}

#forgotPasswordLink:active {
  border-color: #001f3d;
}</style>

<style>


</style>

<script>
function SubmitIt(e,frm){
	_el.CancelEvent(e);
	var fd=new FormData(frm);
	_el.EMPTY(waitDiv);
	waitDiv.className="info";
	ElFetch(waitDiv, _el.CREATE('div','','',{},["Generating Password Recovery"]),
	"generatePasswordRecoveryAjax.php",{method:"POST", body:fd}, "text", {
		success:function(){
			var val=document.querySelector("#email").value;
			_el.EMPTY(document.body);
			_el.APPEND(document.body, [
				_el.CREATE("h1",'','',{},[
					"An email has been sent to: ", val
				])
			]);
		},
		failure:function(){
			waitDiv.className="error";
		}
	},{
		form:frm
	});
}
</script>
</head>
<body>
  <h1>Demo Greg Goad Dot Net Password Recovery</h1>

  <form id="recoveryForm" onsubmit="SubmitIt(event,this)">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
	<br><br>
    <button type="submit">Submit</button>
	<div><a href="."><div id="forgotPasswordLink">Back to the Login Page</div></a></div>
  </form>
  <div id="waitDiv"></div>
</body>
</html>