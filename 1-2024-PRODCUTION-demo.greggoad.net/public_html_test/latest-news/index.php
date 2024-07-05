<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Latest News | Greg Goad</title>
<meta name="description" content="The latest articles published on the site. ">
<meta property="og:title" content="Latest News | Greg Goad">
<meta property="og:description" content="The latest articles published on the site. ">
<meta property="og:type" content="website">
<meta property="og:url" content="https://greggoad.net/latest-news/">
<meta property="og:image" content="https://greggoad.net/media/images/A-Man-and-His-Paper/source.png">
<meta property="og:image:alt" content="A man reading the newspaper in his kitchen with a derby hat on">
<link rel="canonical" href="https://greggoad.net/latest-news/">
<meta name="mobileOptimized" content="true">
<meta name="handheldFriendly" content="true">
<meta name="robots" content="index|follow">
<meta name="DC.title" content="Latest News | Greg Goad">
<meta name="DC.description" content="The latest articles published on the site. ">
<link rel="apple-touch-icon" sizes="180x180" href="/media/icons/regalG/180.png">
<link rel="apple-touch-icon" sizes="152x152" href="/media/icons/regalG/152.png">
<link rel="apple-touch-icon" sizes="120x120" href="/media/icons/regalG/120.png">
<link rel="icon" sizes="16x16" href="/media/icons/regalG/16.png">
<link rel="icon" sizes="32x32" href="/media/icons/regalG/32.png">
<link rel="icon" sizes="57x57" href="/media/icons/regalG/57.png">
<link rel="icon" sizes="76x76" href="/media/icons/regalG/76.png">
<link rel="icon" sizes="96x96" href="/media/icons/regalG/96.png">
<link rel="icon" sizes="120x120" href="/media/icons/regalG/120.png">
<link rel="icon" sizes="128x128" href="/media/icons/regalG/128.png">
<link rel="icon" sizes="144x144" href="/media/icons/regalG/144.png">
<link rel="icon" sizes="152x152" href="/media/icons/regalG/152.png">
<link rel="icon" sizes="167x167" href="/media/icons/regalG/167.png">
<link rel="icon" sizes="180x180" href="/media/icons/regalG/180.png">
<link rel="icon" sizes="192x192" href="/media/icons/regalG/192.png">
<link rel="icon" sizes="195x195" href="/media/icons/regalG/195.png">
<link rel="icon" sizes="196x196" href="/media/icons/regalG/196.png">
<link rel="icon" sizes="228x228" href="/media/icons/regalG/228.png">
<link rel="shortcut icon" sizes="196x196" href="/media/icons/regalG/196.png">
<meta name="msapplication-TileImage" content="/media/icons/regalG/144.png">
<meta name="msapplication-TileColor" content="rebeccapurple">
<meta name="msapplication-config" content="/browserconfig.xml">

<script>
/*START el */
/* START _element */
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
/*END el*/

/*START ob2 */
/* START _object */
_ob=_object={
	/* this is a legacy function. A long time ago, this was how you 'did' inheritance in JS */
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
		};
	})(),
	/* combine 2 object into a new object */
	COMBINE:function(ob1, ob2){
		ob1=ob1 || {};
		ob2=ob2 || {};
		var ret={};
		this.INSERT(ret, ob1);
		this.INSERT(ret, ob2);
		return ret;
	},
	/* insert members into a reciever object */
	INSERT:function(reciever, con){
		con = con || {};
		for(var mem in con)
		{
			reciever[mem]=con[mem];
		}
	},
	/*  this could probably be removed */
	PARSE_default:function(def,set){
	   return this.COMBINE(def,set);
	},
	/* compare two objects, key by key */
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
	/* a control to set how deep clone will run recursively */
	CLONE_depthLimit:20,
	/* clone an object */
	CLONE:(function(){
		return function(obj, depth, callDepth){
			depth=depth || 1;
			callDepth=callDepth || 0;
			if(depth === -1){
				depth = this.CLONE_depthLimit;
				if(callDepth === this.CLONE_depthLimit){
					throw new TypeError("Depth limit reached: ", obj);
				}
			}
			
			if((obj === null || typeof obj !== "object") || (callDepth === depth || callDepth === this.CLONE_depthLimit)){
				return obj;
			}
			if(obj instanceof Date){
				return new Date(obj.getTime());
			}
			if(Array.isArray(obj)){
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
		};
	})()
};

/* Array.isArray polyfill */
if(!Array.isArray){
	Array.isArray=function(a){
		if(typeof a === "object" && a.constructor === Array){
			return true;
		}
	}
}
	

/* END _object*/

/*END ob2*/

/*START fun2 */
/* this is just so we have a function when we have to execute something,
// so we don't have to create an empty function every time (expensive in JS) */
function DUMMY_FUNCT(){}
_fun={
	curryScope:function(fun,scp){
		return function(){
			fun.apply(scp,arguments);
		};
	},
	curryArgs:function(fun, arg){
		if(!Array.isArray(arg)){throw new TypeError('Arg must be an array');}
		return function(){
			fun.apply({}, arg);
		};
	},
	curryScopeArgs:function(fun,scp,arg){
		if(!Array.isArray(arg)){throw new TypeError('Arg must be an array');}
		return function(){
			fun.apply(scp,arg);
		};
	},
	/* run an array of functions. keep indicates whether to erase the array after */
	RunQue:function(arr, keep){
	   arr.forEach(function(a){a();});
	   if(!keep){arr.length=0;}
	}
};
/*END fun2*/

/*START VCR2_basic */
function VC(targetFunct, insertOb, config){
	this.currentView=0;
	this.previousView=0;
	this.nextView=0;
	this.viewsVisited=0;
	this.views=[];
	
	
        this.indexMap={};
        this.safeMap={};

	if(targetFunct){
		this.targetFunct=targetFunct;
	}

	this.currentTarget=false;

        this.active=false;
	this.config=config || {};
	this.activeConfig=this.config;
	this.onchange=[];
	this.afterchange=[];
	this.onrelease=[];
	this.onlaunch=[];
	
	this.historyChange=null;
	this.captured=false;
	this.capParent=null;
	this.capTargetFunct=null;
	this.capConfig=null;
        this.capChildren=[];

        this.reg_elements=[];
        this.reg_timeouts=[];
        this.reg_intervals=[];
		this.reg_goodObjects=[];
		
        if(insertOb){
                for(var mem in insertOb)
                {
                   if(typeof this[mem] !== "undefined"){
                      throw new TypeError("The member "+mem+" already exists in the view controller");
                   }
                   this[mem]=insertOb[mem];
                }
	}
}
VC.prototype.is_VC=true;
VC.prototype.targetFunct=function(){
	return document.body;
};
VC.prototype.GET_viewList=function(){
   return Object.values(this.indexMap);
};
VC.prototype.GET_target=function(emptyTarget){
	var ret;
	if(this.captured && this.capTargetFunct){
		ret=this.capTargetFunct();
	}else{
		ret=this.targetFunct();
	}
	if(emptyTarget){
		_el.EMPTY(ret);
	}
	return this.currentTarget=ret;
};
VC.prototype.GET_viewName=function(v){
    return this.indexMap[this.safeMap[v || this.currentView]];
};
VC.prototype.REGISTER_viewData=function(dat){
   var nm=this.GET_viewName();
   this[nm].viewData=dat;
   var sv=this[nm];
   this.REGISTER_changeANDrelease(function(){sv.viewData={};});
   
};
VC.prototype.PUSH_viewData=function(dat){
   this.stagedViewData=dat;
};
VC.prototype.GET_viewData=function(){
   return this[this.GET_viewName()].viewData;
};
VC.prototype.REGISTER_view=function(name, f, insertOb, config){
        if(typeof this[name] !== "undefined"){throw new TypeError('Name already exists on this view controller: '+name);}
	this.views.push(f);
        if(insertOb && !insertOb.viewData){insertOb.viewData={};}
	this[name]=insertOb || {viewData:{}};
         var i=this.views.length-1;
         this.safeMap[name]=i; this.safeMap[i]=i;
         this.indexMap[i]=name;
	this.config[name]=config || {};
};
VC.prototype.REGISTER_changeANDrelease=function(f){
        this.onrelease.push(f);this.onchange.push(f);
};
VC.prototype.REGISTER_release=function(f){
   this.onrelease.push(f);
};
VC.prototype.REGISTER_goodObject=function(o){
	this.reg_goodObjects.push(o);
	return o;
};
VC.prototype.REGISTER_element=function(e){
    this.reg_elements.push(e);
    return e;
};
VC.prototype.REGISTER_timeout=function(t){
    this.reg_timeouts.push(t);
    return t;
};
VC.prototype.REGISTER_interval=function(i){
    this.reg_intervals.push(i);
    return i;
};
VC.prototype.CLEANUP=function(){
    while(this.reg_elements.length){
           _el.REMOVE(this.reg_elements.pop());
        }
        while(this.reg_timeouts.length){
           clearTimeout(this.reg_timeouts.pop());
        }
        while(this.reg_intervals.length){
           clearInterval(this.reg_intervals.pop());
        }
		while(this.reg_goodObjects.length){
			var r=this.reg_goodObjects.pop().good=false;
			if(r.target){_el.REMOVE(r.target);}
		}
        while(this.capChildren.length)
        {this.capChildren.pop().RELEASE();}
};
VC.prototype.EventCHANGE=function(e, v,dat,f,config){this.CHANGE(v,dat,f,config);_el.CancelEvent(e);};
VC.prototype.MainButtonCHANGE=function(el,e,v,dat,f,config){
   //_el.MoveId('selectedNavButton', el);
   this.ToggleNav(false);
   this.EventCHANGE(e,v,dat,f,config);
};
VC.prototype.CHANGE=function(v, dat, f, config){
	switch(typeof v){
            case "string":
            case "number":
               break;
             default:
                v=this.stagedView || this.currentView;
                this.stagedView='';
                break;
        }
        if(this.safeMap[v] === this.safeMap[this.currentView]){return;}
        this.viewsVisited++;
        VC.prototype.VCR_depth++;
        this.CLEANUP();
	if(this.views.length){
                v=this.safeMap[v];
                this.previousView=this.currentView;
		this.currentView=v;
		


                this.active=true;
                var lgger;
                if(
                   !this.config.noLog 
                   && (!config || config && !config.noLog) 
                   && (!this.config.noLogByView || !this.config.noLogByView[v])
                   && this.VCR_depth === 1
                ){
                   
                   lgger=this.LOG_change;
                   
                }
                VC.prototype.VCR_depth--;

                if(this.stagedViewData){
                   dat=this.stagedViewData; this.stagedViewData=null;
                }

		_fun.RunQue([
                   _fun.curryArgs(_fun.RunQue, [this.onchange]),
                   _fun.curryScope(function(){if(dat){this.REGISTER_viewData(dat);}}, this),
                   _fun.curryArgs(this.views[v],[this]),
                   _fun.curryArgs(_fun.RunQue, [this.afterchange]),
                   f || DUMMY_FUNCT, 
                   _fun.curryScope(lgger || DUMMY_FUNCT,this)
                   
                ]);
                this.historyChange=null;
	}
};
VC.prototype.VCR_depth=0;
VC.prototype.LAUNCH=function(v, dat, f, config){
	_fun.RunQue([
		_fun.curryArgs(_fun.RunQue, [this.onlaunch, true]),
		_fun.curryScopeArgs(this.CHANGE, this, [v,dat,f,config])
	]);
};
VC.prototype.CAPTURE=function(par, tar, conf){
        conf=conf || {};
	if(par && par.is_VC){
                par.capChildren.push(this);
		this.captured=true;
		this.capParent=par;
		this.capTargetFunct=tar;
		this.capConfig=_ob.COMBINE(this.config, conf);
		this.activeConfig=this.capConfig;
	}else{
		throw new TypeError("par was not a view controler...", par);
	}
};

VC.prototype.RELEASE=function(a){
        this.active=false;
	this.captured=false;
	this.capParent=undefined;
	this.capTargetFunct=undefined;
	this.capConfig=undefined;
	this.activeConfig=this.config;
        this.CLEANUP();        
	_fun.RunQue(this.onrelease);
        _fun.RunQue(this.onchange);
        if(this.config.resetViewOnRelease){
			if(this.historyChange === true){
				this.historyChange=null;
			}else{
				this.currentView=0;
			}
        }
};
VC.prototype.INCR=function(){
    this.CHANGE((this.currentView+1)%this.views.length);
};
VC.prototype.DECR=function(){
    var c=this.currentView-1; 
    if(c<0){c=this.views.length-1;}
    this.CHANGE(c);
};
VC.prototype.HAS_view=function(str){
    return (Object.values(this.safeMap).indexOf(str) >= 0);
};
VC.prototype.ToggleNav=function(way){
   var docuElem=document.documentElement;
   if(typeof way === "undefined"){way=!docuElem.classList.contains('navActive');}
   if(way){
      docuElem.style.paddingRight=(window.innerWidth-docuElem.clientWidth)+"px";
      docuElem.classList.add("navActive");
   }else{
      docuElem.classList.remove("navActive");
      docuElem.style.removeProperty('padding-right');
   }
};
VC.prototype.ActiveViewClass='activeView-Latest-News-Articles';
VC.prototype.BasicProjectView=function(n){
   return function(a){
      var activeClass='activeView-'+n.replace(/\s/g,'-');
      document.body.classList.remove(a.ActiveViewClass);
      document.body.classList.add(activeClass);
    //  alert('here'+this.ActiveViewClass);
      a.ActiveViewClass=activeClass;
      var pd=a.pageData[n];

      _hist.documentTitle=pd.title;
       
      _hist.url='https://greggoad.net/'+pd.url;
      
var appButtons=Array.from(document.getElementsByClassName('appButtons'));
appButtons.forEach(function(ab){
	var abdat=APPBUTTONDATA[ab.id.replace('appButton-','')][VCR.main.GET_viewName()] || {};
	var sav=ab.parentNode.href=(abdat).destination || '';
	if(!sav){ab.parentNode.classList.add('hideAppButton');}else{ab.parentNode.classList.remove('hideAppButton')};
	ab.parentNode.removeAttribute('title');ab.parentNode.removeAttribute('aria-label');
	if(abdat.title){ab.parentNode.setAttribute('title',abdat.title);}
	if(abdat.ariaLabel){ab.parentNode.setAttribute('aria-label',abdat.ariaLabel);}
});


      var curTar=a.currentTarget || document.getElementById('contentTarget1');
      var tar=a.GET_target();
      curTar=curTar || tar;
      var loadFinished=false;
      var heightSave=curTar.scrollHeight;

      var historyChange=a.historyChange;
      
      var docElem=document.documentElement;
      var header=document.querySelector('header');
      var mai=document.querySelector('main');
      var scrollTopSave=docElem.scrollTop;
      
      var spinnerTimeout;
      var spinnerInterval;
      var spinnerContainer;
      var viewsVisitedIndex=a.viewsVisited;
      if(a.GET_viewName() !== 'siteNav'){VCR.main.ToggleNav(false);}

      
		function LD(){
			var docuAniWrapper=document.getElementById("docuAniWrapper");
			var direction=curTar.id.replace("contentTarget","")+"-"+tar.id.replace("contentTarget", "");
			var infoToter={curTar:curTar, tar:tar};
			var curViewsVisited=VCR.main.viewsVisited;

			
			
			
			
			curTar.style.removeProperty("top");
			curTar.style.removeProperty("min-height");
			tar.style.removeProperty("top");
			tar.style.removeProperty("min-height");
			mai.style.removeProperty("max-height");
			
			var curTarHeightSave=curTar.scrollHeight;
			
			//debugger;
			loadFinished=true;
			tar.innerHTML=a.pageData[n].html;
			
			
			
			var tarHeightSave=tar.scrollHeight;
			//console.log("heightSave1",tarHeightSave);
			var docHeightSave=document.documentElement.clientHeight;
			
			docuAniWrapper.className="aniPre"+direction;
			//debugger;
			Array.from(tar.querySelectorAll("script")).forEach(function(s){_el.APPEND(tar, _el.CREATE("script","","",{text:s.text}));});

			
			var botcat=(Array.from(document.getElementsByClassName("appButtons")).filter(function(e){return e.offsetTop < 50;}).reduce(function(acc,e){return Math.max(e.offsetTop+e.offsetHeight, acc);},0));
			var headerOffset=header.offsetTop+header.scrollHeight;
			
			var inc=0;
			
			
			var newScrollTop=Math.min(scrollTopSave,headerOffset);//+(window.headerBottomAdjusted ? -botcat : botcat));
				//console.log("newScrollCheck",scrollTopSave,headerOffset, botcat);
			
				
			
				
				
			//console.log(history.state.lastScroll);
			if(history.state && history.state.lastScroll && historyChange){
				newScrollTop=parseInt(history.state.lastScroll);
				var scrollTopAdjustment=newScrollTop;
				
				curTar.style.top=""+(scrollTopAdjustment-scrollTopSave)+"px";
				
				curTar.style.minHeight=(docHeightSave+parseInt(history.state.lastScroll || 0))+"px";
				
				docElem.scrollTop=scrollTopAdjustment;
			}else{
				//debugger;
				if(headerOffset < scrollTopSave && !window.headerBottomAdjusted){
					inc=botcat;
					mai.style.marginTop=botcat+"px";
					headerBottomAdjusted=true;
					history.replaceState(_ob.COMBINE(history.state,{botcat:botcat}),"");
				}
					//console.log(a.historyChange, "from inside");
				curTar.style.minHeight=tarHeightSave+"px";
				curTar.style.top="-"+(scrollTopSave-newScrollTop+inc)+"px";
				docElem.scrollTop=newScrollTop;
				
			}
			
			clearTimeout(window.shortAniTimeout);
			clearTimeout(window.mainAniTimeout);
			shortAniTimeout=setTimeout(function(){
				//debugger;
				//if(window.runTest){window.runTest--; if(!window.runTest){clearTimeout(window.mainAniTimeout);return;}}
				//debugger;
				docuAniWrapper.className="aniAni"+direction;
				//debugger;
				if(infoToter.afterFireIn){infoToter.afterFireIn();}
				if(infoToter.afterFireOut){infoToter.afterFireOut();}

                
				mai.style.maxHeight=(tarHeightSave)+"px";


				clearTimeout(window.mainAniTimeout);
				mainAniTimeout=setTimeout(function(){
					if(curViewsVisited !== VCR.main.viewsVisited){
						return;
					}
					//return;
					mai.style.removeProperty("max-height");
					//console.log("actualHeight", tar.scrollHeight);
					//debugger;
					docuAniWrapper.className="aniRest"+tar.id.replace("contentTarget","");
					//debugger;
					curTar.style.removeProperty("top");
					curTar.style.removeProperty("min-height");
					curTar.innerHTML="";
					//console.log(tarHeightSave, document.documentElement.clientHeight, mai.clientHeight);
					///console.log(tar.clientHeight, tar.offsetHeight, tar.scrollHeight);
					//history.replaceState(_ob.COMBINE(history.state,{collapseOffset:(document.documentElement.scrollHeight-docuAniWrapper.clientHeight)+1}), "");
				},1*1000);
			
			},1);
			
		}

      if(pd.js && !pd.jsLoaded){
         var scr=_el.CREATE('script','','',{onload:function(){
            pd.jsLoaded=true;
            if(loadFinished && pd.igniterFunction){
               pd.igniterFunction();
            }
         }});
         scr.src="/"+pd.url+'/js.js';
         _el.APPEND(document.head, scr);
         
      }
      if(pd.css && !pd.cssLoaded){
         spinnerTimeout=setTimeout(function(){
            var aniCat;
            _el.APPEND(document.body, 
                spinnerContainer=_el.CREATE('div','','',{style:{position:'fixed', top:'50%', width:'100%',left:'0', backgroundColor:'rgba(0, 0, 0, 0.5)', padding:'4px'}},[_el.CREATE('div','','',{style:{position:'relative',display:'inline-block',padding:'10px',backgroundColor:'white'}},[
                   "Loading Page Data:",
                   aniCat=_el.CREATE('div','','',{},["."]),
                   "There appears to be a slow connection"
                ])])
            );
            var num=1;
            spinnerInterval=setInterval(function(){aniCat.innerHTML=".".repeat(num);  num%=5;num++;},100);
         },500);
         var link=_el.CREATE('link','','',{rel:'stylesheet', onload:function(){
            
            pd.cssLoaded=true;
            clearTimeout(spinnerTimeout);clearInterval(spinnerInterval);
            _el.REMOVE(spinnerContainer);
            if(a.viewsVisited === viewsVisitedIndex){
               LD();
            }
         },onerror:function(){
            clearTimeout(spinnerTimeout);clearInterval(spinnerInterval);_el.REMOVE(spinnerContainer);
            if(a.viewsVisited === viewsVisitedIndex){LD();}
         }});

         link.href="/"+pd.url+'/css.css';
         _el.APPEND(document.head, link);
      }else{
         LD();
      }
      
      
   };
};

VC.prototype.pageData={"Home":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1>My name is Greg Goad<\/h1>\n\n<h2>Here are the interests I want to share with the world:<\/h2>\n<div>\n<a class=\"invisiAnchors\" href=\"\/my-salvation-in-christ\" onclick=\"VCR.main.EventCHANGE(event, 'My Salvation In Christ');\"><div class=\"continueButtons\">\nMy Salvation in Christ\n<\/div><\/a><a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\">\nMusic\n<\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\">\nMath\n<\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\">\nSoftware\n<\/div><\/a>\n<br>\n<span class=\"blackTextBacker\">(These buttons will take you to new sections)<\/span>\n<\/div>\n<h2 class=\"leaveSpace\">Every Page is Interactive<\/h2>\n<h3>Click a shape and watch it explode.<\/h3>\n\n<div class=\"leaveSpace leaveSpaceAfter\">\n<h2>See the \n<a href=\"\/latest-news\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Latest News Articles');\">\n<span class=\"inlineContinueButtons\">\n Latest News \n<\/span>\n<\/a>\n<\/h2>\n<\/div>\n\n<figure class=\"leaveSpace leaveSpaceAfter perspectiveFixers\">\n<div class=\"coinImage coinSpin\" onclick=\"FastXSpin(this); \" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Reali-Reality\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/256x256.png 1x, \/media\/images\/Reali-Reality\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/128x128.png 1x, \/media\/images\/Reali-Reality\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/64x64.png 1x, \/media\/images\/Reali-Reality\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/32x32.png 1x, \/media\/images\/Reali-Reality\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Reali-Reality\/source.png\" alt=\"Reali Reality in the X-D Cube\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption class=\"blackTextBacker\">What can you see?!?!\n<\/figcaption>\n<\/figure>\n<div class=\"blackTextJump\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>\n","url":"","igniterFunction":false,"title":"Home | Greg Goad"},"Music":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"faceHeaders\">Music<\/h1>\n<span class=\"softLabel\">My Teaching: <\/span><a href=\"\/jammaday\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Jammaday');\"><div class=\"continueButtons\">\nJammaday Academy\n<\/div><\/a>\n<hr class=\"shortHrs\">\n<span class=\"softLabel\">My Band: <\/span><a href=\"\/mochobo\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Mochobo');\"><div class=\"continueButtons\">\nMochobo\n<\/div><\/a>\n\n<div class=\"faceTextBacker leaveSpace\">\n<h2>My First Career<\/h2>\n<p>\n   My first career was music. I've played hundreds of gigs, for thousands of hours. I thank God for bringing me into music. A study of the harmonic series brought me into my \n   <a href=\"\/math\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Math');\"><span class=\"inlineContinueButtons\">\nMath Research\n<\/span><\/a>. The math research and the desire to promote my music led me to \n<a href=\"\/software\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Software');\"><span class=\"inlineContinueButtons\">\nSoftware Development\n<\/span><\/a>\n<\/p>\n<\/div>","url":"music\/","igniterFunction":false,"title":"My Music Career | Greg Goad"},"Software":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"faceHeaders\">Software<\/h1>\n<a href=\"\/tech-stack\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Tech Stack');\"><div class=\"continueButtons\">\nTech Stack\n<\/div><\/a>\n<a href=\"\/apps-and-libraries\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Apps and Libraries');\"><div class=\"continueButtons\">\nApps &amp; Libraies\n<\/div><\/a>\n<a href=\"\/waa\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Web Apps Actualized');\"><div class=\"continueButtons\">\nWAA\n<\/div><\/a>\n\n<div class=\"faceTextBacker leaveSpace\">\n<h2>The New Career<\/h2>\n<p>\n   My journey in software started in 2014, with a bunch of programs in C++ to \n   <a href=\"\/factoring\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Factoring');\"><span class=\"inlineContinueButtons\">\nFactor Integers\n<\/span><\/a>. \nAs I began to mature as a developer, I saw how the internet could be used to promote my \n<a href=\"\/music\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Music');\"><span class=\"inlineContinueButtons\">\nMusic\n<\/span><\/a>. I began down the road, and ended up in a giant hole of creating tooling. When I started, the idea of web applications was newer, and far less mature than it is now. I took the first two and a half years to create a lightweight front-end applicaction framework. \n<\/p>\n<p>\nThen, I created a plan to achieve my promotion goals, and I spent the next 5 years fleshing out the rest of my \n\n<a href=\"\/tech-stack\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Tech Stack');\"><span class=\"inlineContinueButtons\">\nTech Stack\n<\/span><\/a>.\nNow, as of the time of this writing (December 2023), I'm at the very end of getting the ball rolling on the promotion engine.\n\n<\/p>\n<\/div>\n<div class=\"faceTextBacker leaveSpace\">\n<h3 class=\"parHeading\">Around the Net<\/h3>\n<h4 class=\"subHeading\">(Open in New Windows)<\/h4>\n<p>\n<ul>\n<li><a class=\"invisiAnchors\" href=\"https:\/\/ggHireMe.com\" target=\"_BLANK\">\n   <span class=\"socialLogos\"><picture><source srcset=\"\/media\/images\/Regal-G\/512x512.png\" media=\"(min-width:2560px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/256x256.png 1x, \/media\/images\/Regal-G\/512x512.png 2x\" media=\"(min-width:1280px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/128x128.png 1x, \/media\/images\/Regal-G\/256x256.png 2x\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/64x64.png 1x, \/media\/images\/Regal-G\/128x128.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/32x32.png 1x, \/media\/images\/Regal-G\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Regal-G\/source.png\" alt=\"A Regal G in gold.\" width=\"1024\" height=\"1024\" \/><\/picture><\/span>My Programming Portfolio<\/a><\/li>\n   <li><a class=\"invisiAnchors\" href=\"https:\/\/github.com\/ggoad\" target=\"_BLANK\">\n   <span class=\"socialLogos\"><picture><source srcset=\"\/media\/images\/gitHub-Invertocat-dark\/120x120.png\" media=\"(min-width:600px)\" type=\"image\/png\" width=\"120\" height=\"120\" \/>\n<source srcset=\"\/media\/images\/gitHub-Invertocat-dark\/60x60.png 1x, \/media\/images\/gitHub-Invertocat-dark\/120x120.png 2x\" media=\"(min-width:300px)\" type=\"image\/png\" width=\"60\" height=\"60\" \/>\n<source srcset=\"\/media\/images\/gitHub-Invertocat-dark\/30x30.png 1x, \/media\/images\/gitHub-Invertocat-dark\/60x60.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"30\" height=\"30\" \/>\n<img src=\"\/media\/images\/gitHub-Invertocat-dark\/source.png\" alt=\"The github invertocat dark\" width=\"240\" height=\"240\" \/><\/picture><\/span>GitHub<\/a><\/li>\n<\/ul>\n<\/p>\n<\/div>","url":"software\/","igniterFunction":false,"title":"Web Applications and Toolchains | Greg Goad"},"Math":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"faceHeaders\">Math<\/h1>\n<a href=\"\/factoring\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Factoring');\"><div class=\"continueButtons\">\nFactoring\n<\/div><\/a>\n<a href=\"\/unbalanced-algebra\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Unbalanced Algebra');\"><div class=\"continueButtons\">\nUnbalanced Algebra\n<\/div><\/a>\n\n<div class=\"faceTextBacker leaveSpace\">\n<h2>A Deep Calling<\/h2>\n<p>\nMy math research is the intercessor between my \n   <a href=\"\/music\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Music');\"><span class=\"inlineContinueButtons\">\nmusic\n<\/span><\/a> career and my \n   <a href=\"\/software\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Software');\"><span class=\"inlineContinueButtons\">\nsoftware\n<\/span><\/a>\ncareer. \n<\/p>\n<p>\nI became inspired to research the \n   <a href=\"\/factoring\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Factoring');\"><span class=\"inlineContinueButtons\">\nfactoring of integers\n<\/span><\/a> after a study I did in music of the harmonic series. I discovered a thing called the 'lambdoma matrix', although I didn't know the name at the time, and became obsessed with it. I tried to apply it in many different places, until I found factoring. I poured my soul into it. I wrote a bunch of programs at the beginning, and then began a many-year long research into pure mathematics. The coolest thing I found was \n<a href=\"\/unbalanced-algebra\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Unbalanced Algebra');\"><span class=\"inlineContinueButtons\">\nunbalanced algebra\n<\/span><\/a>, \nbut I also found all kinds of other cool things that I'm super proud of. In my mid 30s, I intend on collecting my research and publishing it. \n<\/p>\n<\/div>","url":"math\/","igniterFunction":false,"title":"Math Research | Greg Goad"},"Jammaday":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"fishTextBacker\">Jammaday Academy<\/h1>\n<figure class=\"leaveSpace leaveSpaceAfter\">\n<div class=\"coinImage\" onclick=\"FastZSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\" >\n<picture><source srcset=\"\/media\/images\/Jammaday-Apple-Old\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/256x256.png 1x, \/media\/images\/Jammaday-Apple-Old\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/128x128.png 1x, \/media\/images\/Jammaday-Apple-Old\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/64x64.png 1x, \/media\/images\/Jammaday-Apple-Old\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/32x32.png 1x, \/media\/images\/Jammaday-Apple-Old\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Jammaday-Apple-Old\/source.png\" alt=\"A worm coming out of an apple playing a guitar and smiling\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption><span class=\"fishTextFixer\">Look at the blast he's having!<\/span><\/figcaption>\n<\/figure>\n<div class=\"fishTextBacker\">\n<h2>A Source of Joy<\/h2>\n<p>\n   I've taught music for 15 years and I've been taught continuously for 10 (minus the pandemic). There's very little besides my children that brings me as much joy as teaching.\n<\/p>\n<p>\n   <span>Music saved my life...<\/span> by giving me direction at a time when I was wandering lost. It kept me out of trouble; it gave me a purpose. That's why I feel it's so important to pass it along.\n<\/p>\n<p>\n   I've spent most of my teaching operating under the name 'Greg Goad Music Instruction'. However, I'm slowly rebranding to Jammaday Academy.\n<\/p>\n<p>\n   There is a dream for Jammaday Academy to be a franchise, focused on tutoring, that helps people achieve the skills they need or want in life.\n<\/p>\n<p>\nIf you are interested in enrollment, just \n<a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\"><span class=\"inlineContinueButtons\">\ncontact me\n<\/span><\/a>. I teach the guitar, bass, piano, drums and ukulele. I serve the piedmont triad, NC.\n<\/p>\n<\/div>\n\n<figure class=\"perspectiveFixers\">\n<div class=\"basicImage coinSpin\" onclick=\"ScaleImgOut(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Music-Notes\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/256x256.png 1x, \/media\/images\/Music-Notes\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/128x128.png 1x, \/media\/images\/Music-Notes\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/64x64.png 1x, \/media\/images\/Music-Notes\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/32x32.png 1x, \/media\/images\/Music-Notes\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Music-Notes\/source.png\" alt=\"3 Eighth Notes. The beginnings of a symphony.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption><span class=\"fishTextFixer\">Doobee do Wah<\/span><\/figcaption>\n<\/figure>\n\n<div class=\"fishTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"jammaday\/","igniterFunction":false,"title":"Jammaday Academy | Greg Goad"},"Mochobo":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"cloudTextBacker\">Mochobo<\/h1>\n\n<figure class=\"perspectiveFixers\">\n<div class=\"coinImage\" onclick=\"FastXSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\" >\n\n<picture><source srcset=\"\/media\/images\/Mochobo\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/256x256.png 1x, \/media\/images\/Mochobo\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/128x128.png 1x, \/media\/images\/Mochobo\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/64x64.png 1x, \/media\/images\/Mochobo\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/32x32.png 1x, \/media\/images\/Mochobo\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Mochobo\/source.png\" alt=\"Mochobo smoking a cigar\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>Welcome, My Friend!<\/figcaption>\n<\/figure>\n\n<div class=\"cloudTextBacker\">\n<p>\n   <i>Mochobo is the name of a monkey: the monkey in my head. Sometimes, I wisht he would shut up!<\/i>\n<\/p>\n<p>\n  This is the name I release my music under. I've played a ton of music for other people, but this is mine. \n<\/p>\n<p>\nWhenever I record new music, it gets published on <span class=\"externalNewWindowLinks\"><a target=\"_BLANK\" href=\"http:\/\/mochobo.net\">Mochobo.net<\/a><\/span>. \n<\/p>\n<\/div>\n\n<figure class=\"\">\n<div class=\"basicImage\" onclick=\"ScaleImgOut(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Purple-Haze\/682x1023.jpeg\" media=\"(min-width:852px)\" type=\"image\/jpeg\" width=\"682\" height=\"1023\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/341x511.jpeg 1x, \/media\/images\/Purple-Haze\/682x1023.jpeg 2x\" media=\"(min-width:426px)\" type=\"image\/jpeg\" width=\"341\" height=\"511\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/170x255.jpeg 1x, \/media\/images\/Purple-Haze\/341x511.jpeg 2x\" media=\"(min-width:212px)\" type=\"image\/jpeg\" width=\"170\" height=\"255\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/85x127.jpeg 1x, \/media\/images\/Purple-Haze\/170x255.jpeg 2x\" media=\"(min-width:106px)\" type=\"image\/jpeg\" width=\"85\" height=\"127\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/42x63.jpeg 1x, \/media\/images\/Purple-Haze\/85x127.jpeg 2x\" media=\"(min-width:52px)\" type=\"image\/jpeg\" width=\"42\" height=\"63\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/21x31.jpeg 1x, \/media\/images\/Purple-Haze\/42x63.jpeg 2x\" media=\"(min-width:1px)\" type=\"image\/jpeg\" width=\"21\" height=\"31\" \/>\n<img src=\"\/media\/images\/Purple-Haze\/source.jpeg\" alt=\"A photo of Greg Goad playing bass live on stage under purple concert lighting and fog. Taken by Moon Daze photography.\" width=\"1365\" height=\"2048\" \/><\/picture>\n<\/div>\n<figcaption>Thanks to Matt Way at Moon Daze Photography for the Picture!<\/figcaption>\n<\/figure>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"mochobo\/","igniterFunction":false,"title":"Mochobo | Greg Goad"},"Factoring":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"fishTextBacker\">Factoring Integers<\/h1>\n\n<figure class=\"leaveSpace leaveSpaceAfter\">\n<div class=\"coinImage halfOpaImg\" onclick=\"FastZSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Quadratic-Bloom\/500x500.png\" media=\"(min-width:625px)\" type=\"image\/png\" width=\"500\" height=\"500\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/250x250.png 1x, \/media\/images\/Quadratic-Bloom\/500x500.png 2x\" media=\"(min-width:312px)\" type=\"image\/png\" width=\"250\" height=\"250\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/125x125.png 1x, \/media\/images\/Quadratic-Bloom\/250x250.png 2x\" media=\"(min-width:156px)\" type=\"image\/png\" width=\"125\" height=\"125\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/62x62.png 1x, \/media\/images\/Quadratic-Bloom\/125x125.png 2x\" media=\"(min-width:77px)\" type=\"image\/png\" width=\"62\" height=\"62\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/31x31.png 1x, \/media\/images\/Quadratic-Bloom\/62x62.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"31\" height=\"31\" \/>\n<img src=\"\/media\/images\/Quadratic-Bloom\/source.png\" alt=\"The the beginning of making real progress in the factoring question.\" width=\"2000\" height=\"2000\" \/><\/picture>\n<\/div>\n<figcaption><span class=\"fishTextFixer\">Searching and Sieving<\/span><\/figcaption>\n<\/figure>\n<div class=\"fishTextBacker\">\n<p>\n   I've spent way too much time studying the factoring of integers. In many ways it was fun, and in other ways it was not. I never landed on the holy grail, but I did find a bunch of neat and awesome things. I challenged the norm.\n\nThe coolest thing I found was \n<a href=\"\/unbalanced-algebra\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Unbalanced Algebra');\">\n<span class=\"inlineContinueButtons\">\n Unbalanced Algebra \n<\/span>.\n<\/a>\n<\/p>\n<h2>What I'll do With It<\/h2>\n<p>\n   In my mid to late 30s, I'm going to collect it all... and publish the things I've found on Arxiv.\n<\/p>\n<\/div>\n\n<div class=\"fishTextBacker concurrentSection\">\n   <h2>An Example<\/h2>\n   <noscript><h3>IMPORTANT: JavaScript is required for this interface to work.<\/h3><\/noscript>\n<p>\n   This is a small example of a factoring program. It's not the most efficient program I've ever written... however, it would do no good to run a super efficient program in a web browser anyway.\n<\/p>\n<p>\n   Alternatively, this is just the most recent algorithm I wrote. Spending time piddling on it was my gift to myself for Christmas.\n<\/p>\n<\/div>\n\n<div class=\"fishTextBacker concurrentSection\">\n<h2 class=\"parHeading\">Interface<\/h2>\n<h3 class=\"subHeading\">Factor an Interger<\/h3>\n   <div>\n      <div id=\"factorSizeLimitLabel\" class=\"factorSizeLimitActive\">\n      <label onchange=\"FactoritState.Submit(document.querySelector('#integerInput').value);\">\n         Size Limits: \n         <input onchange=\"this.parentNode.parentNode.className=(this.checked?'factorSizeLimitActive' : 'factorSizeLimitRemoved');\" id=\"factorSafeSizeLimits\" name=\"safeSizeLimits\" type=\"checkbox\" checked\/>\n      <\/label>\n      <\/div>\n      <br>\n      <label>\n      Integer: \n      <input onchange=\"FactoritState.Submit(this.value)\" min=\"1\" name=\"integer\" id=\"integerInput\" type=\"number\" value=\"1\" \/>\n      <\/label><br>\n      <button id=\"factorSubmit\" onclick=\"FactoritState.Submit(document.querySelector('#integerInput').value);\">Factor<\/button>\n      <output for=\"integerInput\" id=\"factoringResult\">\n         \n      <\/output>\n      \n   <\/div>\n<\/div>\n\n<div class=\"fishTextBacker concurrentSection\">\n   <h2>How it Works<\/h2>\n   <p>\n      The math behind this algorithm is relatively naive... however, the management of the JavaScript state and the demands\/limitations of the stack frames made it more difficult.\n   <\/p>\n   <h3>The Math<\/h3>\n    <p>\n      There are basically 4 steps.\n   <\/p>\n      <ol class=\"factoringList\">\n        <li><span class=\"smallLabel\">Indexed Check:<\/span> As you enter numbers, the results are saved. The first thing the algorith does is check if the number being factored has been saved.<\/li>\n        <li><span class=\"smallLabel\">Small Check:<\/span> If the number isn't already saved, then the first 30 primes are checked as divisors. Instead of an additive algorithm, it naively uses modulo.<\/li>\n        <li><span class=\"smallLabel\">Semi-Quadratic Check:<\/span> This step isn't actually a full-quadric seive. But it is an interesting and easily-implemented algorithm that eliminates factors from the squareroot downward (like a quadratic sieve).<\/li>\n        <li><span class=\"smallLabel\">Brute Check:<\/span> A cutoff is calculatated at the beginning of the process, and if the quadratic sieve reaches it, then the algorithm begins to just brute-force modulo up to the cutoff.<\/li>\n      <\/ol>\n   <h3>The JavaScript<\/h3>\n   <p>\n      Several problems had to be solved to have this in a web browser.\n   <\/p>\n      <ul class=\"factoringList\">\n        <li><span class=\"smallLabel\">Call Stack Limitations:<\/span> JavaScript has a maximum call stack that is much smaller than you would encounter in other languages. Normally, you wouldn't run into problems having to do with that unless you had a bug in your program. However, in this mathematically intensive process, the call stack can get many hundreds of thousands deep if you use recursion. My solution to this was to use the function setTimeout every so many calls to create a new call stack, leveraging closure so that the new instance could see the arugments.<\/li>\n        <li><span class=\"smallLabel\">Cancelable Factoring:<\/span> I needed a mechanism to be able to cancel any factoring calls. To either move to a new integer or change sections. I've included 2 features to achieve this. First, I included a 'call index' in that gets incremented on every call to the function Submit. All of the meat-and-potatoes function in the class check that this value hasn't changed, and if they have, they return. Second, the function Submit also clears any timeouts set by the class before proceding with a new factoring.<\/li>\n        <li><span class=\"smallLabel\">Non-Blocking Factoring:<\/span> The timeouts keep the thread from being blocked. In order for the animations to continue to run smoothly, I opted for shorter calculation spurts. The timeouts give the animation time to calculate, and a window of time for the browser to process user input.<\/li>\n        <li><span class=\"smallLabel\">Application Cleanup:<\/span> Upon changing sections, I wanted to make sure any factoring calculation was canceled. I registered an listener with VCR.js to make sure the call index was incremented, and any timeouts were canceled. I included a flag in the class to that gets flipped on the first call to submit, so that registereing the event listener can be deferred until it is needed, and will only be set once. The flag gets unset in the listener itself.<\/li>\n      <\/ul>\n   <h3>A Clear Implementation of the Semi-Quadratic Sieve<\/h3> \n   <p>\n      So, if you read the JavaScript on this page, it will be all twisted up with the work needed to get this to run safely inside of a browser.\n   <\/p>\n   <p>\n       I'm pretty proud of that part of the algorithm, because of how simple it is. Here is a clear implementation in Haskel, without all of the JavaScript noise:\n   <\/p>\n<code class=\"factoringCodeExample\">\n<div>\nimport Data.List<br>\nimport System.IO<br>\n<br><br>\nrunnit :: Integer -> Integer -> Integer -> Integer -> String\n<br>\n<br>\nrunnit x y t n<br>\n<span class=\"tabbed\"> | x <= 0 || y <= 0 = \"error\"<\/span><br>\n<span class=\"tabbed\">| t < n = runnit x (y+1) (t+x) n<\/span><br>\n<span class=\"tabbed\">| t > n = runnit (x-1) y (t-y) n<\/span><br>\n<span class=\"tabbed\">| otherwise = show x ++ \" x \" ++ show y ++ \" = \" ++ show n<\/span>      \n<br><br><br>\nfactorit :: Integer -> String \n<br>\n<pre>\nfactorit x = \n let sr=sqrt(fromIntegral x)\n in let bottom=floor(sr)\n        top=ceiling(sr)\n in let tot = bottom*top\n in runnit bottom top tot x \n<\/pre>\n<br>\n<pre>\nmain = do\n print \"Enter your number: \";\n numInp <- getLine\n let n = read numInp :: Integer\n\n print (factorit(n))\n<\/pre>\n<\/div>\n<\/code>\n<\/div>\n<figure class=\"leaveSpace\">\n<div class=\"coinImage\" onclick=\"ScaleImgOut(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/What-Was-I-Thinking\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/256x256.png 1x, \/media\/images\/What-Was-I-Thinking\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/128x128.png 1x, \/media\/images\/What-Was-I-Thinking\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/64x64.png 1x, \/media\/images\/What-Was-I-Thinking\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/32x32.png 1x, \/media\/images\/What-Was-I-Thinking\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/What-Was-I-Thinking\/source.png\" alt=\"A man questioning his life decisions.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption><span class=\"fishTextFixer\">It hurt, but I loved it!<\/span><\/figcaption>\n<\/figure>\n<div class=\"fishTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"factoring\/","igniterFunction":false,"title":"Factoring Integers | Greg Goad"},"Unbalanced Algebra":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"\n<h1 class=\"cloudTextBacker\">Unbalanced Algebra<\/h1>\n<figure class=\"\">\n<div class=\"coinImage\" onclick=\"FastZSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Pi-In-The-Sun\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/256x256.png 1x, \/media\/images\/Pi-In-The-Sun\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/128x128.png 1x, \/media\/images\/Pi-In-The-Sun\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/64x64.png 1x, \/media\/images\/Pi-In-The-Sun\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/32x32.png 1x, \/media\/images\/Pi-In-The-Sun\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Pi-In-The-Sun\/source.png\" alt=\"The symbol for Pi inside of a sun radiating out from a hollow center\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>The Radiance!<\/figcaption>\n<\/figure>\n<div class=\"cloudTextBacker\">\n<p>\nOf all of the things I've found while researching the \n<a href=\"\/factoring\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Factoring');\"><span class=\"inlineContinueButtons\">\nfactoring of integers\n<\/span><\/a>, the coolest thing has been unbalanced algebra. It is a method for solving systems of parametric equations in the domain of algebra, and it gets its name from what I was studying when it was found.\n<\/p>\n<p>\nI haven't published it for a fear of someone stealing my work. I've found this algebra, but have not solved any real unsolved problems with it. After I found it, I shifted my efforts to computer programming (because I have to feed my family), with the intention of re-visiting it after I finsihed a certain amount of work in that domain.\n<\/p>\n<p>\nBut as I get older, I realize it's selfish. What if I died? As of now (December 2023), I'm at the very end of what I wanted to achieve in computer programming. The first thing I'm going to do when I get there is go ahead and publish Unbalanced Algebra on Arxiv, before I dive into finding an application for it, and before I've collected the rest of my research.\n<\/p>\n<\/div>\n\n<figure class=\"leaveSpace perspectiveFixers\">\n<div class=\"basicImage coinSpin\" onclick=\"FastXSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/one-equals-two\/559x266.png\" media=\"(min-width:698px)\" type=\"image\/png\" width=\"559\" height=\"266\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/279x132.png 1x, \/media\/images\/one-equals-two\/559x266.png 2x\" media=\"(min-width:348px)\" type=\"image\/png\" width=\"279\" height=\"132\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/139x66.png 1x, \/media\/images\/one-equals-two\/279x132.png 2x\" media=\"(min-width:173px)\" type=\"image\/png\" width=\"139\" height=\"66\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/69x32.png 1x, \/media\/images\/one-equals-two\/139x66.png 2x\" media=\"(min-width:86px)\" type=\"image\/png\" width=\"69\" height=\"32\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/34x16.png 1x, \/media\/images\/one-equals-two\/69x32.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"34\" height=\"16\" \/>\n<img src=\"\/media\/images\/one-equals-two\/source.png\" alt=\"How could the statement 1 equals 2 contain any kind of insight?\" width=\"2237\" height=\"1066\" \/><\/picture>\n<\/div>\n<figcaption>Sense in NonSense<\/figcaption>\n<\/figure>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"unbalanced-algebra\/","igniterFunction":false,"title":"Unbalanced Algebra | Greg Goad"},"Tech Stack":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"cloudTextBacker\">My Tech Stack<\/h1>\n<div id=\"techStackWrapper\">\n<div class=\"cloudTextBacker\">\n<h2>Notepad and a Web Browser<\/h2>\n<p>\nI chose to focus web development because of the accessibility (all you need is notepad), and how I could see use for it compared to my life in music. I've used this tech stack in the production of dozens of <a href=\"\/apps-and-libraries\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Apps and Libraries');\"><span class=\"inlineContinueButtons\"> Applications <\/span><\/a>.\n<\/p>\n<\/div>\n\n<figure class=\"\">\n<div class=\"coinImage\" onclick=\"ScaleImgOut(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\"> \n<picture><source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/256x256.png 1x, \/media\/images\/The-Horse-and-The-Screen\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/128x128.png 1x, \/media\/images\/The-Horse-and-The-Screen\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/64x64.png 1x, \/media\/images\/The-Horse-and-The-Screen\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/32x32.png 1x, \/media\/images\/The-Horse-and-The-Screen\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/The-Horse-and-The-Screen\/source.png\" alt=\"A Man on the Horse and the horse has its face right on the screen of a desktop\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>\"I believe I can see myself in this\"<\/figcaption>\n<\/figure>\n\n<div class=\"cloudTextBacker\">\n<h2>Launguages<\/h2>\n<ul>\n<li><span class=\"softLabel\">JavaScript: <\/span>I consider myself a JavaScript expert... and then they release a new language feature (&#9786). Some of it is really cool. I'm often worried about using the newest features on front-facing public applications, because of the lag of adoption on older devices. I flex my JS harder in administrative sections, and login dashboards. Typescript could be a solution to this, as its type information allows for the transpiling down to any arbitrary target of support you desire; transpiling is just not available to vanilla JS, due to its lack of type information<\/li>\n<li><span class=\"softLabel\">CSS: <\/span> I try to put as much of the tranformation and animation into CSS as I can, because the browser can put what it can onto the GPU.<\/li>\n<li><span class=\"softLabel\">HTML: <\/span> Recently, in order to make a shorthand html editor, I dove very deeply into the vast array of tags available in HTML. The dialog tag! And the details tag! It's super awesome that these things are afforded to us in HTML.<\/li>\n<li><span class=\"softLabel\">php: <\/span> I chose php as my server language because of the sentence: 'If they discontinued support for php, the web would shut down'. Php seemed safe because of its indelibility.<\/li>\n<li><span class=\"softLabel\">HTACCESS: <\/span> My dev server is XAMPP, so learning HTACCESS was a natural progression.<\/li>\n<li><span class=\"softLabel\">mySQL: <\/span>I have dove deep into mySQL, including a lot of Meta-Coding of mySQL. <\/li>\n<li><span class=\"softLabel\">SQLite: <\/span>I've built multiple applications with SQLite and love it for many reasons. The greatest of which is the ability to easily copy and move around the database files<\/li>\n<\/ul>\n<h2>Other Tech<\/h2>\n<ul>\n<li><span class=\"softLabel\">WebDev Suite: <\/span><br> A group of tools used for the production of web applications.\n   <ul>\n      <li><span class=\"softLabel\">VCR.js: <\/span> A front-end application framework. Manages application state. Features nested applications.<\/li>\n      <li><span class=\"softLabel\">Site Generator: <\/span> A program to configure and generate the file-tree of complete, correct and performant websites. This with VCR.js answers many similar problems as Angular.<\/li>\n\n      <li><span class=\"softLabel\">Server Manager: <\/span> A precursor to the Site Generator, the Server Manager can place files, edit or remove them from the server. It also features an application rendering engine, which allowed for the easy and flexible management and development of applications using VCR.js.<\/li>\n      <li><span class=\"softLabel\">Ready Made Form (Database Manager): <\/span> This is an ORM. It was extremely difficult to create. It took 3 years. It features a type-system, that is connected to a database editor. Once a table is created, the interface for interacting with the table is rendered at a click of button (meta-coding the MYSQL and php necessary for the basic CRUD interface).<\/li>\n\n   <\/ul>\n<\/li>\n<\/ul>\n<h3>See some <a href=\"\/apps-and-libraries\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Apps and Libraries');\"><span class=\"inlineContinueButtons\"> Applications <\/span><\/a> I've produced with this tech stack.<\/h3>\n<h2 class=\"parHeading\">Web APIs<\/h2>\n<h3 class=\"subHeading\">Some of the APIs I've Implemented<\/h3>\n<ul>\n<li><span class=\"softLabel\">Google Maps: <\/span>I've used the Google Maps API in several different projects, creating several different tools. Far deeper than just embedding a map.<\/li>\n<li><span class=\"softLabel\">Google Recaptcha: <\/span>I've implemented Google Recaptcha multiple times.<\/li>\n<li><span class=\"softLabel\">Twillio: <\/span>An easy API for sending and recieving automated texts.<\/li>\n<li><span class=\"softLabel\">E-Commerce: <\/span><br> Let's accept some credit cards!\n   <ul>\n     <li>PayPal<\/li>\n     <li>Stripe (My Favorite)<\/li>\n     <li>Braintree<\/li>\n   <\/ul>\n<\/li>\n<li><span class=\"softLabel\">PriceCharting.com: <\/span>A small API for checkign up-to-date prices on video games.<\/li>\n<li><span class=\"softLabel\">Ship Station: <\/span>A shipping API. Posting orers with contents, sizes and destinations. Deeper than just hooking it to a paypal, I've had to post orders directly due to strange packaging requirements.<\/li>\n<\/ul>\n<h2>Honorable Mention<\/h2>\n<ul>\n<li><span class=\"softLabel\">C++: <\/span>C++ was actually the first language I learned, way back in middle school. \n<a href=\"\/music\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Music');\"><span class=\"inlineContinueButtons\"> Music <\/span><\/a>\n took me away from diving any further into it. I came back into computer programming through C++, where I used it in the beginning of my \n<a href=\"\/math\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Math');\">\n   <span class=\"inlineContinueButtons\"> \n    number theory research \n   <\/span>\n<\/a>\n.<\/li>\n<li><span class=\"softLabel\">Windows MSDN: <\/span>I've written a few small programs using Windows OS calls. Mostly things with CreateProcess. Web Dev Suite uses a windows program to warm up my server, launch a hub, and launches a thread to monitor a folder on my machine for files. A long time ago, I wrote a progam to take a folder of files, and launch the programs needed to print off pdfs of them\n\n(for my\n\n\n<a href=\"\/jammaday\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Jammaday');\">\n   <span class=\"inlineContinueButtons\"> \n    students \n   <\/span>\n<\/a>). The best \n\n<a href=\"\/factoring\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Factoring');\">\n   <span class=\"inlineContinueButtons\"> \n    factoring \n   <\/span>\n<\/a>\n program I've written could factor any 64 bit number on an old laptop.<\/li>\n<li><span class=\"softLabel\">BASIC: <\/span>I've ventured into BASIC just a tad, through writing procedures for OpenOffice Calc (an open source alternative to excel).<\/li>\n<li><span class=\"softLabel\">Haskel: <\/span>I've written a small amount of Haskel. Mostly for number theory research.<\/li>\n<\/ul>\n<\/div>\n<\/div>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<h3>My Tech Portfolio<\/h3>\n<p>\nA in-depth breakdown of how all of this fits together can be found in my <a href=\"https:\/\/gghireme.com\" target=\"_BLANK\" class=\"externalNewWindowLinks\">Tech Portfolio<\/a>. Check it out! It was fun to make. \n<\/p>\n<\/div>\n\n<figure class=\"leaveSpace\">\n<div class=\"coinImage\" onclick=\"FastZSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/UI-Reality\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/256x256.png 1x, \/media\/images\/UI-Reality\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/128x128.png 1x, \/media\/images\/UI-Reality\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/64x64.png 1x, \/media\/images\/UI-Reality\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/32x32.png 1x, \/media\/images\/UI-Reality\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/UI-Reality\/source.png\" alt=\"A faux diagram for bringing a UI into reality.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>\"The man with the plan\"<\/figcaption>\n<\/figure>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>\n","url":"tech-stack\/","igniterFunction":false,"title":"Tech Stack | Greg Goad"},"Apps and Libraries":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"\n<h1 class=\"fishTextBacker\">Apps &amp; Libraries<\/h1>\n<figure class=\"\">\n<div class=\"coinImage\" onclick=\"FastZSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Telephone\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Telephone\/256x256.png 1x, \/media\/images\/Telephone\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Telephone\/128x128.png 1x, \/media\/images\/Telephone\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Telephone\/64x64.png 1x, \/media\/images\/Telephone\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Telephone\/32x32.png 1x, \/media\/images\/Telephone\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Telephone\/source.png\" alt=\"A phone waiting to be answered.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>Just a reminder: you can \n<a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\"><span class=\"inlineContinueButtons\"> Call Me <\/span><\/a>\n<\/figcaption>\n<\/figure>\n\n\n<div class=\"fishTextBacker appsNLibraries-container\">\n<h2>Libraries<\/h2>\n<p>\nHere are a few libraries that I've produced that I'm very proud of. These are libraries that I actually use often.\n<\/p>\n<ul>\n   <li><span class=\"softLabel\">VCR.js:<\/span> (<b>V<\/b>iew <b>C<\/b>ont<b>r<\/b>oler) A real-deal front-end web application framework. It handles browser history and application state. This library is available on my <a href=\"https:\/\/github.com\/ggoad\/VCR\" target=\"_BLANK\" class=\"externalNewWindowLinks\">GitHub<\/a><\/li>\n   <li><span class=\"softLabel\">RMF.js:<\/span> (<b>R<\/b>eady <b>M<\/b>ade <b>F<\/b>orm) This was very difficult to create. It is a library that accepts a declarative array of objects to define a form. The object are of the form: <center><code class=\"codeExample\"><pre>\n{\n   name:'string - input name', \n   type:'string - type of input', \n   \/*further configuration pertaining to the type of input*\/\n}<\/pre><\/code><\/center> The data can be retreived as a JSON object with the function COLL, and then the function SET can be call with the return value of COLL to return to the form state later. \n    <br><br>\n    <details>\n    <summary>Example Usage<\/summary>\n    <center><code class=\"codeExample\"><div><pre>\n\/\/ the RMF library is ommitted, because the input type definitions are rather large.\n\/\/ Usage:\n     \nvar rmf=RMFORM(\n   \/\/ html element to act as the target for the form\n   document.body, \n   [ \/\/ input list\n      {name:'title', labelText:'Title', type:'singleLine'},\n      {name:'isPublished', labelText:'Is Published', type:'checkbox'},\n   ],\n   'myTestForm',\/\/ just a name for the form\n   { \/\/ configuration. There are several\n      collProc:function(c){\n         \/\/ this function indicates what to do on submit. Here just as an example.\n         \/\/ a simple ajax submission\n         var fd=new FormData();\n         fd.append('dat', JSON.stringify(c));\n         fetch('yourAjaxEndpoint.php', {method:'POST', body:fd})\n            .then(function(res){\n               return ret.text();\n            })\n            .then(function(txt){\n               alert('The response was '+txt);\n            }).catch(function(e){\n               alert('Error');\n            });\n      } \n   }\n);\n\n\/\/ Then you can grab the form this way:\nvar result=rmf.COLL();\n\n\/\/ result is something like this: {\"title\":\"Your Title\", \"published\":true}\n\n\/\/ If you save the object for later, you can return to the form state like:\nrmf.SET(result);\n\n\n\/\/ Using this, you can build large and complicated forms.\n<\/pre>\n<\/div>\n    <\/code><\/center>\n    <\/details>\n   <br><br>\n   You can find the whole front-end portion of RMF.js on my <a href=\"https:\/\/github.com\/ggoad\/RMF\" target=\"_BLANK\" class=\"externalNewWindowLinks\">GitHub<\/a>\n   <\/li>\n<\/ul>\n\n<\/div>\n<div class=\"fishTextBacker leaveSpace appsNLibraries-container\">\n<h2>Applications<\/h2>\n<p>\nMost of the applications I've built up until now (December 2023), have been geared toward tooling. Along with a few web pages to test the tooling, and a few video games for fun. Right now, I'm in the middle of rebuilidng everything. As I get things moved to their new home, I'll add links.\n<\/p>\n<ul>\n<li><span class=\"softLabel\">WebDev Suite: <\/span> This is a group of tools I've created to assist in the production of web applications. I include many of these in the <a href=\"\/tech-stack\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Tech Stack');\"><span class=\"inlineContinueButtons\"> Tech Stack <\/span><\/a> page, because they are part of a front-end or back-end framework (similar to Vue.js or React and Angular).\n<ul>\n      <li><span class=\"softLabel\">Site Generator: <\/span> A program to configure and generate the file-tree of complete, correct and performant websites. This with VCR.js answers many similar problems as Angular.<\/li>\n\n      <li><span class=\"softLabel\">Server Manager: <\/span> A precursor to the Site Generator, the Server Manager can place files, edit or remove them from the server. It also features an application rendering engine, which allowed for the easy and flexible management and development of applications using VCR.js.<\/li>\n      <li><span class=\"softLabel\">Ready Made Form (Database Manager): <\/span> This is an ORM. It was extremely difficult to create. It took 3 years. It features a type-system, that is connected to a database editor. Once a table is created, the interface for interacting with the table is rendered at a click of button (meta-coding the MYSQL and php necessary for the basic CRUD interface).<\/li>\n\n\n\n   <\/ul>\n\n<\/li>\n<li><span class=\"softLabel\">Invoice to Inbox: <\/span> This is turn-key invoicing software. Track your business's income, customers, jobs, expenses, and mileage. Emit email notifications, and send bills and receipts to your customers in PDF form.<\/li>\n<li><span class=\"softLabel\">P-Graph: <\/span> A research tool. It graphs parametric equations which you provide.<\/li>\n<li><span class=\"softLabel\">The Daily Wizard: <\/span>I created this tool to collect information about my life in the evenings, and schedule work for me in the mornings.<\/li>\n<li><span class=\"softLabel\">Games: <\/span> I've made right many video games. Most of them I've only spent a day or two on. I make them as a reward to myself for reaching stopping points on the dry, terrible stuff. Hopefully, I'll have up-to-date links to these soon.\n<ul>\n   <li><span class=\"softLabel\">War Stars: <\/span> A game where you control a blue star attacking a bunch of green stars. Fun for about 30 seconds.<\/li>\n   <li><span class=\"softLabel\">Block Drop: <\/span> A tetris clone. Pretty fun. It is very easy to add custom pieces.<\/li>\n   <li><span class=\"softLabel\">Assault on Wayoon 7: <\/span> This is the most fun game I've made. Just a short game loop, but the enemies are fun to destroy. It has an arcade feel to it.<\/li>\n   <li><span class=\"softLabel\">Simply Checkers: <\/span> I made this for a baby shower, during the pandemic, so family who were sick could interact with the family if they wanted to. It included networking online (playing another player live). And a messaging interface. I used polling to keep the state up-to-date, so it really isn't scalable from a server-perspective.<\/li>\n<\/ul>\n<\/li>\n<li><span class=\"softLabel\">Math Programs: <\/span>I have made an absolute ton of factoring programs, and other programs to explore patterns and ideas in the research of number theory. The best factoring program I've written was a single-threaded application written in C++ which was a combination of a quadratic sieve and an additive trial divisor. It reached the limits of 64-bit numbers. A simpler algorithm is featured in the <a href=\"\/factoring\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Factoring');\"><span class=\"inlineContinueButtons\"> Factoring Section <\/span><\/a><\/li>\n<\/ul>\n\n\n<\/div>\n\n<div class=\"fishTextBacker leaveSpace\">\n<h3>My Tech Portfolio<\/h3>\n<p>\nA in-depth breakdown of how all of this fits together can be found in my <a href=\"https:\/\/gghireme.com\" target=\"_BLANK\" class=\"externalNewWindowLinks\">Tech Portfolio<\/a>. Check it out! It was fun to make. \n<\/p>\n<\/div>\n\n<figure class=\"leaveSpace perspectiveFixers\">\n<div class=\"coinImage coinSpin\" onclick=\"FastXSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/runningMan\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/runningMan\/256x256.png 1x, \/media\/images\/runningMan\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/runningMan\/128x128.png 1x, \/media\/images\/runningMan\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/runningMan\/64x64.png 1x, \/media\/images\/runningMan\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/runningMan\/32x32.png 1x, \/media\/images\/runningMan\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/runningMan\/source.png\" alt=\"A man running toward his future, laid out for him by his computer.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption><span class=\"fishTextFixer\">Running to the Future<\/span><\/figcaption>\n<\/figure>\n\n<div class=\"leaveSpace fishTextBacker\">\n<p>\nIf you have an idea for an application, feel free to <a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\"><span class=\"inlineContinueButtons\"> Contact Me <\/span><\/a>. At the very least, I can present you with a pathway to actualizing your dreams.\n<\/p>\n<\/div>\n\n\n\n<div class=\"fishTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"apps-and-libraries\/","igniterFunction":false,"title":"Portfolio | Greg Goad"},"Web Apps Actualized":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"\n<h1 class=\"parHeading cloudTextBacker\">Web Apps Actualized<br><span class=\"subHeading innerSubHeading\">Bringing Business<br>Dreams to Reality<\/span><\/h1>\n\n\n\n<figure class=\"perspectiveFixers\">\n<div class=\"coinImage coinSpin\" onclick=\"FastXSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Money-Man\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/256x256.png 1x, \/media\/images\/Money-Man\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/128x128.png 1x, \/media\/images\/Money-Man\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/64x64.png 1x, \/media\/images\/Money-Man\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/32x32.png 1x, \/media\/images\/Money-Man\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Money-Man\/source.png\" alt=\"A man full of joy running toward a giant dollar sign.\" width=\"1024\" height=\"1024\" \/><\/picture>\n\n<\/div>\n<figcaption>We all have the dream.<\/figcaption>\n<\/figure>\n\n\n\n<div class=\"cloudTextBacker\">\n<h2>What <i>WAA<\/i> Does<\/h2>\n<h3>Web Consulting and Production<\/h3>\n<p>\n   Do you need a website built? An application? What are your dreams? We can bring them into reality. The more people tell you it's not possible, the more important it is for you to <a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\"><span class=\"inlineContinueButtons\"> Get in Touch <\/span><\/a>. \n<\/p>\n\n<h3>Contract Work<\/h3>\n<p>\n   If you have a tech company in need of clean, correct code: call me. Browse the languages and technologies I can help you with on the <a href=\"\/tech-stack\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Tech Stack');\"><span class=\"inlineContinueButtons\"> Tech Stack Page <\/span><\/a>.\n<\/p>\n<h3>More Information<\/h3>\n<p>\nYou can find more information on the <a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\"><span class=\"inlineContinueButtons\"> Contact <\/span><\/a> page or by visiting <span class=\"externalNewWindowLinks\"><a target=\"_BLANK\" href=\"https:\/\/webappsactualized.com\">WebAppsActualized.com<\/a><\/span>.\n<\/p>\n\n\n\n<\/div>\n<figure class=\"leaveSpace leaveSpaceAfter perspectiveFixers\">\n<div class=\"basicImage coinSpin\" onclick=\"ScaleImgOut(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Black-Hole-Phone\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/256x256.png 1x, \/media\/images\/Black-Hole-Phone\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/128x128.png 1x, \/media\/images\/Black-Hole-Phone\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/64x64.png 1x, \/media\/images\/Black-Hole-Phone\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/32x32.png 1x, \/media\/images\/Black-Hole-Phone\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Black-Hole-Phone\/source.png\" alt=\"A bunch of phones falling into a black hole\" width=\"1024\" height=\"1024\" \/><\/picture>\n\n<\/div>\n<figcaption>Escape from the bottomless tech hole... \n<a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\"><span class=\"inlineContinueButtons\"> Call Me <\/span><\/a>\n Today<\/figcaption>\n<\/figure>\n\n\n<div class=\"cloudTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"waa\/","igniterFunction":false,"title":"Web Apps Actualized | Greg Goad"},"Contact":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1>Contact<\/h1>\n\n<h2 class=\"leaveSpace\">Phone Number<\/h2>\n<div id=\"RPC-Contact_Information\">\r\n\t\t<noscript>Sorry, but scripting is required for this section to function.<\/noscript>\r\n\t\t<script>\r\n\t\tCookieManager.GetPermission(\"grecaptcha\", (VCR.main.currentTarget || document).querySelector('#RPC-Contact_Information'), function(){\r\n\t\t   _el.APPEND((VCR.main.currentTarget || document).querySelector('#RPC-Contact_Information'), [\r\n\t\t      _el.CREATE('div','','',{},[\"I protect this information with a bot-deterrent provided by Google. Click the button below to request the information.\"]),\r\n\t\t\t  _el.CREATE('button','','RPC-ChallengeButton',{onclick:function(){\r\n\t\t\t\t  var t=this;\r\n\t\t\t\t  var comEl=document.getElementById('RPC-Contact_Information-CommunicatorEl');\r\n\t\t\t\t\t_el.APPEND(comEl,'Performing Recaptcha Challenge');\r\n\t\t\t\t  grecaptcha.ready(function() {\r\n\t\t\t\t\t  grecaptcha.execute('6LdKd-AnAAAAACf_hGED7w0l5gTtFSM-191RLTiy', {action: 'RPC\/Contact_Information'}).then(function(token) {\r\n\t\t\t\t\t\t  var fd=new FormData();\r\n\t\t\t\t\t\t  fd.append('recaptchaToken', token);\r\n\t\t\t\t\t\t  _el.EMPTY(comEl);\r\n\t\t\t\t\t\t  ElFetch(comEl, 'Requesting Information', '\/recapProtContent_\/Contact_Information\/request.php', {method:'POST', body:fd}, 'json',{\r\n\t\t\t\t\t\t\t  success:function(jsn){\r\n\t\t\t\t\t\t\t\t  _el.EMPTY(comEl);\r\n\t\t\t\t\t\t\t\t  var tar=document.querySelector('#RPC-Contact_Information');\r\n\t\t\t\t\t\t\t\t  \r\n\t\t\t\t\t\t\t\t  _el.EMPTY(tar);\r\n\t\t\t\t\t\t\t\t  tar.innerHTML=jsn.html;\r\n\t\t\t\t\t\t\t  },\r\n\t\t\t\t\t\t\t  fail:function(){\r\n\t\t\t\t\t\t\t\t  _el.EMPTY(comEl);\r\n\t\t\t\t\t\t\t\t  _el.APPEND(comEl,'Your request failed.');\r\n\t\t\t\t\t\t\t  }\r\n\t\t\t\t\t\t  },{\r\n\t\t\t\t\t\t\t  button:t\r\n\t\t\t\t\t\t  });\r\n\t\t\t\t\t  });\r\n\t\t\t\t\t});\r\n\t\t\t  }},[\"Reveal Contact Information\"]),\r\n\t\t\t  _el.CREATE('div','RPC-Contact_Information-CommunicatorEl','',{}),\r\n\t\t\t  _el.CREATE('div','','',{},[_el.CREATE('span','','',{},['This section is protected by reCAPTCHA (A Google Service) ',_el.CREATE('br'), 'See Google\\'s ',_el.CREATE('a','','',{href:'https:\/\/policies.google.com\/privacy'},['Privacy Policy']), ' and ',_el.CREATE('a','','',{href:'https:\/\/policies.google.com\/terms'},['Terms of Service'])])])\r\n\t\t   ]);\r\n\t\t}, 'to view '+\"the contact information\");\r\n\t\t<\/script>\r\n\t\t<\/div>\n\n<h2 class=\"leaveSpace leaveSpaceAfter\">-OR-<\/h2>\n\n<script>\r\n\t\t\t\r\n\t\t\tfunction ContactForm_Contact_Submit(frm){\r\n\t\t\t\tvar fd=new FormData(frm);\r\n\t\t\t\t\t  var comEl=document.getElementById('ContactForm-Contact-CommunicatorEl');\r\n\t\t\t\t_el.APPEND(comEl, 'Performing the Recaptcha Check...');\r\n\t\t\t\tfrm.setAttribute('disabled','');\r\n\t\t\t\t\r\n\t\t\t\tif(!window.grecaptcha || !window.grecaptcha.ready){\r\n\t\t\t\t\t_el.EMPTY(comEl);\r\n\t\t\t\t\t_el.APPEND(comEl, ['The Google Recaptcha library failed to load. You may be disconnected from the internet. Please try again later. ', _el.CREATE('button','','',{onclick:function(){_el.EMPTY(this.parentNode);}},['Dismiss'])]);\r\n\t\t\t\t\treturn;\r\n\t\t\t\t}\r\n\t\t\t\tgrecaptcha.ready(function() {\r\n\t\t\t\t  grecaptcha.execute('6LdKd-AnAAAAACf_hGED7w0l5gTtFSM-191RLTiy', {action: 'ContactForm\/Contact\/submit'}).then(function(token) {\r\n\t\t\t\t\t  fd.append('recaptchaToken', token);\r\n\t\t\t\t\t  _el.EMPTY(comEl);\r\n\t\t\t\t\t  frm.removeAttribute('disabled');\r\n\t\t\t\t\t  ElFetch(comEl, 'Sending your information', '\/contactForms_\/Contact.php', {method:'POST', body:fd}, 'text',{\r\n\t\t\t\t\t\t  success:function(){\r\n\t\t\t\t\t\t\t  _el.EMPTY(comEl);\r\n\t\t\t\t\t\t\t  _el.APPEND(comEl, ['Your Form Was Submitted: ' , _el.CREATE('button','','',{onclick:function(){_el.EMPTY(this.parentNode);}},['Dismiss'])]);\r\n\t\t\t\t\t\t\t  _el.EMPTY(frm);\r\n\t\t\t\t\t\t\t  _el.APPEND(frm, _el.CREATE('h3','','',{},['Your Submission was Received! Thank you.']));\r\n\t\t\t\t\t\t  },\r\n\t\t\t\t\t\t  fail:function(){_el.EMPTY(comEl);_el.APPEND(comEl, ['Your Form Submission Failed ' , _el.CREATE('button','','',{onclick:function(){_el.EMPTY(this.parentNode);}},['Dismiss'])]);}\r\n\t\t\t\t\t  },{\r\n\t\t\t\t\t\t  form:frm\r\n\t\t\t\t\t  });\r\n\t\t\t\t  });\r\n\t\t\t\t});\r\n\t\t\t}\r\n\t\t<\/script><form onsubmit=\"_el.CancelEvent(event); ContactForm_Contact_Submit(this);\" class=\"contactForm\" id=\"contactMeForm\" method=\"POST\" name=\"contactForm-Contact\" >\r\n\t\t\t<h2>Contact Me<\/h2>\r\n\t\t\t<label for=\"contactForm-Contact-email\" >Email<\/label>\n<input id=\"contactForm-Contact-email\" name=\"email\" required=\"\" autocomplete=\"on\" type=\"email\" \/>\n<label for=\"contactForm-Contact-question\" >Your Question<\/label>\n<textArea id=\"contactForm-Contact-question\" name=\"question\" required=\"\" maxLength=\"400\" ><\/textArea>\n<br><br>\r\n\t\t\t<div id=\"contactForm-Contact-submitTarget\">\r\n\t\t\t<noscript>This form uses Recaptcha. Because of this, it is required for JavaSript to be enabled to use this form. Submitting this form without JavaScript will cause it to be rejected automatically.<\/noscript>\r\n<script>\r\nCookieManager.GetPermission(\"grecaptcha\", (VCR.main.currentTarget || document).querySelector('#contactForm-Contact-submitTarget'), function(){\r\n   _el.APPEND((VCR.main.currentTarget || document).querySelector('#contactForm-Contact-submitTarget'), [\r\n      _el.CREATE('button','','contactFormSubmitButton',{},['Submit']),\r\n\t  _el.CREATE('div','','',{},[_el.CREATE('span','','',{},['This site is protected by reCAPTCHA (A Google Service) ',_el.CREATE('br'), 'See Google\\'s ',_el.CREATE('a','','',{href:'https:\/\/policies.google.com\/privacy'},['Privacy Policy']), ' and ',_el.CREATE('a','','',{href:'https:\/\/policies.google.com\/terms'},['Terms of Service'])])])\r\n   ]);\r\n}, 'for the submit button.');\r\n<\/script>\r\n<\/div>\r\n<br><br>\r\nVisit our <a href=\"\/privacy-policy.html\">Privacy Policy<\/a>\r\n<div id=\"ContactForm-Contact-CommunicatorEl\" class=\"ContactForm-CommunicatorEls\"><\/div>\r\n\t\t<\/form>\n\n\n<figure class=\"leaveSpace perspectiveFixers\">\n<div class=\"coinImage\" onclick=\"FastXSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Telephone\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Telephone\/256x256.png 1x, \/media\/images\/Telephone\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Telephone\/128x128.png 1x, \/media\/images\/Telephone\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Telephone\/64x64.png 1x, \/media\/images\/Telephone\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Telephone\/32x32.png 1x, \/media\/images\/Telephone\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Telephone\/source.png\" alt=\"A phone waiting to be answered.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption class=\"blackTextBacker\">Rrrrrring, Ring!\n<\/figcaption>\n<\/figure>\n<div class=\"leaveSpace\">\n<h2>Find Us On \n<a href=\"\/social-media\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Social Media');\">\n<span class=\"inlineContinueButtons\">\n Social Media\n<\/span>\n<\/a>\n<\/h2>\n<\/div>\n<div class=\"cloudTextBacker leaveSpace spaceTextJump\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>\n\n\n","url":"contact\/","igniterFunction":false,"title":"Contact | Greg Goad"},"Credits":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"cloudTextBacker\">Site Credits<\/h1>\n\n<div class=\"cloudTextBacker\">\n<h2>Images<\/h2>\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Mochobo<\/h3>\n   <picture><source srcset=\"\/media\/images\/Mochobo\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/256x256.png 1x, \/media\/images\/Mochobo\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/128x128.png 1x, \/media\/images\/Mochobo\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/64x64.png 1x, \/media\/images\/Mochobo\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Mochobo\/32x32.png 1x, \/media\/images\/Mochobo\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Mochobo\/source.png\" alt=\"Mochobo smoking a cigar\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Telephone<\/h3>\n   <picture><source srcset=\"\/media\/images\/Telephone\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Telephone\/256x256.png 1x, \/media\/images\/Telephone\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Telephone\/128x128.png 1x, \/media\/images\/Telephone\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Telephone\/64x64.png 1x, \/media\/images\/Telephone\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Telephone\/32x32.png 1x, \/media\/images\/Telephone\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Telephone\/source.png\" alt=\"A phone waiting to be answered.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Music Notes<\/h3>\n   <picture><source srcset=\"\/media\/images\/Music-Notes\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/256x256.png 1x, \/media\/images\/Music-Notes\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/128x128.png 1x, \/media\/images\/Music-Notes\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/64x64.png 1x, \/media\/images\/Music-Notes\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Music-Notes\/32x32.png 1x, \/media\/images\/Music-Notes\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Music-Notes\/source.png\" alt=\"3 Eighth Notes. The beginnings of a symphony.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Puple Haze<\/h3>\n   <picture><source srcset=\"\/media\/images\/Purple-Haze\/682x1023.jpeg\" media=\"(min-width:1364px)\" type=\"image\/jpeg\" width=\"682\" height=\"1023\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/341x511.jpeg 1x, \/media\/images\/Purple-Haze\/682x1023.jpeg 2x\" media=\"(min-width:682px)\" type=\"image\/jpeg\" width=\"341\" height=\"511\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/170x255.jpeg 1x, \/media\/images\/Purple-Haze\/341x511.jpeg 2x\" media=\"(min-width:340px)\" type=\"image\/jpeg\" width=\"170\" height=\"255\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/85x127.jpeg 1x, \/media\/images\/Purple-Haze\/170x255.jpeg 2x\" media=\"(min-width:170px)\" type=\"image\/jpeg\" width=\"85\" height=\"127\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/42x63.jpeg 1x, \/media\/images\/Purple-Haze\/85x127.jpeg 2x\" media=\"(min-width:84px)\" type=\"image\/jpeg\" width=\"42\" height=\"63\" \/>\n<source srcset=\"\/media\/images\/Purple-Haze\/21x31.jpeg 1x, \/media\/images\/Purple-Haze\/42x63.jpeg 2x\" media=\"(min-width:1px)\" type=\"image\/jpeg\" width=\"21\" height=\"31\" \/>\n<img src=\"\/media\/images\/Purple-Haze\/source.jpeg\" alt=\"A photo of Greg Goad playing bass live on stage under purple concert lighting and fog. Taken by Moon Daze photography.\" width=\"1365\" height=\"2048\" \/><\/picture>\n   <figcaption>Photographed by Matt Way with Moon Daze Photography<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Running Man<\/h3>\n   <picture><source srcset=\"\/media\/images\/runningMan\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/runningMan\/256x256.png 1x, \/media\/images\/runningMan\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/runningMan\/128x128.png 1x, \/media\/images\/runningMan\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/runningMan\/64x64.png 1x, \/media\/images\/runningMan\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/runningMan\/32x32.png 1x, \/media\/images\/runningMan\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/runningMan\/source.png\" alt=\"A man running toward his future, laid out for him by his computer.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Pi in the Sun<\/h3>\n   <picture><source srcset=\"\/media\/images\/Pi-In-The-Sun\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/256x256.png 1x, \/media\/images\/Pi-In-The-Sun\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/128x128.png 1x, \/media\/images\/Pi-In-The-Sun\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/64x64.png 1x, \/media\/images\/Pi-In-The-Sun\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Pi-In-The-Sun\/32x32.png 1x, \/media\/images\/Pi-In-The-Sun\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Pi-In-The-Sun\/source.png\" alt=\"The symbol for Pi inside of a sun radiating out from a hollow center\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Jammaday Apple (Old)<\/h3>\n   <picture><source srcset=\"\/media\/images\/Jammaday-Apple-Old\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/256x256.png 1x, \/media\/images\/Jammaday-Apple-Old\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/128x128.png 1x, \/media\/images\/Jammaday-Apple-Old\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/64x64.png 1x, \/media\/images\/Jammaday-Apple-Old\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Jammaday-Apple-Old\/32x32.png 1x, \/media\/images\/Jammaday-Apple-Old\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Jammaday-Apple-Old\/source.png\" alt=\"A worm coming out of an apple playing a guitar and smiling\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced by Greg Goad with Open Office Draw<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>One Equals Two<\/h3>\n   <picture><source srcset=\"\/media\/images\/one-equals-two\/559x266.png\" media=\"(min-width:1118px)\" type=\"image\/png\" width=\"559\" height=\"266\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/279x132.png 1x, \/media\/images\/one-equals-two\/559x266.png 2x\" media=\"(min-width:558px)\" type=\"image\/png\" width=\"279\" height=\"132\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/139x66.png 1x, \/media\/images\/one-equals-two\/279x132.png 2x\" media=\"(min-width:278px)\" type=\"image\/png\" width=\"139\" height=\"66\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/69x32.png 1x, \/media\/images\/one-equals-two\/139x66.png 2x\" media=\"(min-width:138px)\" type=\"image\/png\" width=\"69\" height=\"32\" \/>\n<source srcset=\"\/media\/images\/one-equals-two\/34x16.png 1x, \/media\/images\/one-equals-two\/69x32.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"34\" height=\"16\" \/>\n<img src=\"\/media\/images\/one-equals-two\/source.png\" alt=\"How could the statement 1 equals 2 contain any kind of insight?\" width=\"2237\" height=\"1066\" \/><\/picture>\n   <figcaption>Produced by Greg Goad with Open Office Draw<\/figcaption>\n   <\/figure>\n   <\/div>\n   \n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Quadratic Bloom<\/h3>\n   <picture><source srcset=\"\/media\/images\/Quadratic-Bloom\/500x500.png\" media=\"(min-width:1000px)\" type=\"image\/png\" width=\"500\" height=\"500\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/250x250.png 1x, \/media\/images\/Quadratic-Bloom\/500x500.png 2x\" media=\"(min-width:500px)\" type=\"image\/png\" width=\"250\" height=\"250\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/125x125.png 1x, \/media\/images\/Quadratic-Bloom\/250x250.png 2x\" media=\"(min-width:250px)\" type=\"image\/png\" width=\"125\" height=\"125\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/62x62.png 1x, \/media\/images\/Quadratic-Bloom\/125x125.png 2x\" media=\"(min-width:124px)\" type=\"image\/png\" width=\"62\" height=\"62\" \/>\n<source srcset=\"\/media\/images\/Quadratic-Bloom\/31x31.png 1x, \/media\/images\/Quadratic-Bloom\/62x62.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"31\" height=\"31\" \/>\n<img src=\"\/media\/images\/Quadratic-Bloom\/source.png\" alt=\"The the beginning of making real progress in the factoring question.\" width=\"2000\" height=\"2000\" \/><\/picture>\n   <figcaption>Produced with a screenshot of Desmos Graphing Calculator by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Black Hole Phone<\/h3>\n   <picture><source srcset=\"\/media\/images\/Black-Hole-Phone\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/256x256.png 1x, \/media\/images\/Black-Hole-Phone\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/128x128.png 1x, \/media\/images\/Black-Hole-Phone\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/64x64.png 1x, \/media\/images\/Black-Hole-Phone\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Black-Hole-Phone\/32x32.png 1x, \/media\/images\/Black-Hole-Phone\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Black-Hole-Phone\/source.png\" alt=\"A bunch of phones falling into a black hole\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>The Horse and the Screen<\/h3>\n   <picture><source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/256x256.png 1x, \/media\/images\/The-Horse-and-The-Screen\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/128x128.png 1x, \/media\/images\/The-Horse-and-The-Screen\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/64x64.png 1x, \/media\/images\/The-Horse-and-The-Screen\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/The-Horse-and-The-Screen\/32x32.png 1x, \/media\/images\/The-Horse-and-The-Screen\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/The-Horse-and-The-Screen\/source.png\" alt=\"A Man on the Horse and the horse has its face right on the screen of a desktop\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>UI Reality<\/h3>\n   <picture><source srcset=\"\/media\/images\/UI-Reality\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/256x256.png 1x, \/media\/images\/UI-Reality\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/128x128.png 1x, \/media\/images\/UI-Reality\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/64x64.png 1x, \/media\/images\/UI-Reality\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/UI-Reality\/32x32.png 1x, \/media\/images\/UI-Reality\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/UI-Reality\/source.png\" alt=\"A faux diagram for bringing a UI into reality.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>What was I Thinking<\/h3>\n   <picture><source srcset=\"\/media\/images\/What-Was-I-Thinking\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/256x256.png 1x, \/media\/images\/What-Was-I-Thinking\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/128x128.png 1x, \/media\/images\/What-Was-I-Thinking\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/64x64.png 1x, \/media\/images\/What-Was-I-Thinking\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/What-Was-I-Thinking\/32x32.png 1x, \/media\/images\/What-Was-I-Thinking\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/What-Was-I-Thinking\/source.png\" alt=\"A man questioning his life decisions.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Money Man<\/h3>\n   <picture><source srcset=\"\/media\/images\/Money-Man\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/256x256.png 1x, \/media\/images\/Money-Man\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/128x128.png 1x, \/media\/images\/Money-Man\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/64x64.png 1x, \/media\/images\/Money-Man\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Money-Man\/32x32.png 1x, \/media\/images\/Money-Man\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Money-Man\/source.png\" alt=\"A man full of joy running toward a giant dollar sign.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   \n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Reali Reality<\/h3>\n   <picture><source srcset=\"\/media\/images\/Reali-Reality\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/256x256.png 1x, \/media\/images\/Reali-Reality\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/128x128.png 1x, \/media\/images\/Reali-Reality\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/64x64.png 1x, \/media\/images\/Reali-Reality\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Reali-Reality\/32x32.png 1x, \/media\/images\/Reali-Reality\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Reali-Reality\/source.png\" alt=\"Reali Reality in the X-D Cube\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>Regal G<\/h3>\n   \n   <picture><source srcset=\"\/media\/images\/Regal-G\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/256x256.png 1x, \/media\/images\/Regal-G\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/128x128.png 1x, \/media\/images\/Regal-G\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/64x64.png 1x, \/media\/images\/Regal-G\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/32x32.png 1x, \/media\/images\/Regal-G\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Regal-G\/source.png\" alt=\"A Regal G in gold.\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n   <div class=\"creditsImage\">\n   <figure>\n   <h3>A Man and His Paper<\/h3>\n   <picture><source srcset=\"\/media\/images\/A-Man-and-His-Paper\/512x512.png\" media=\"(min-width:1024px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/256x256.png 1x, \/media\/images\/A-Man-and-His-Paper\/512x512.png 2x\" media=\"(min-width:512px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/128x128.png 1x, \/media\/images\/A-Man-and-His-Paper\/256x256.png 2x\" media=\"(min-width:256px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/64x64.png 1x, \/media\/images\/A-Man-and-His-Paper\/128x128.png 2x\" media=\"(min-width:128px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/32x32.png 1x, \/media\/images\/A-Man-and-His-Paper\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/A-Man-and-His-Paper\/source.png\" alt=\"A man in a Gatsby hat reading the newspaper at the kitchen table\" width=\"1024\" height=\"1024\" \/><\/picture>\n   <figcaption>Produced with Dall-E 2 AI. Prompted by Greg Goad<\/figcaption>\n   <\/figure>\n   <\/div>\n\n<\/div>\n<div class=\"cloudTextBacker leaveSpace\">\n<h2>Audio<\/h2>\n<ul>\n   <li><span class=\"softLabel\">Jovie's Song<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Roscoe's Song<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Cassie's Song<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Jenna's Song<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Nothing to Loose (Live)<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Dynamo Monkey<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">It is What it Is<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Jenna's Song<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Rain<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Sick of the Scene<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Pot of Gold<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">I've got a Woman<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Alone with Regret<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n      <li>Mixed Down by Jonathan Shirley<\/li>\n   <\/ul><\/li>\n   <li><span class=\"softLabel\">Top of the World (Live)<\/span><ul>\n      <li>Written and Performed by Greg Goad<\/li>\n      <li>Recording Engineer: Jonathan Shirley<\/li>\n      <li>Recorded Live at Stormy Studios in 2022<\/li>\n   <\/ul><\/li>\n<\/ul>\n<div>\nVisit the\n<a href=\"\/music\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Music');\">\n<span class=\"inlineContinueButtons\">\n Music \n<\/span> section\n<\/a>\n<\/div>\n<\/div>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<h2>Art and Animations<\/h2>\n<span>\nAll art and animations were produced by Greg Goad\n<\/span>\n\n<\/div>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<h2>Production<\/h2>\n<span>All code written by Greg Goad<\/span>\n<h3>WebDev Suite<\/h3>\n\n<span class=\"littleCreditsSubs\">VCR.js<\/span>\n<span class=\"littleCreditsSubs\">SiteGenerator<\/span>\n<span class=\"littleCreditsSubs\">Ready-Made Form<\/span>\n\n<h4>Open AI (GPT and Dall-E 2)<\/h4>\n<h4>Thank you Apache<\/h4>\n<br>\n<div>\nVisit the\n<a href=\"\/software\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Software');\">\n<span class=\"inlineContinueButtons\">\n Software \n<\/span> section\n<\/a>\n<\/div>\n<\/div>\n\n<div class=\"cloudTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"credits\/","igniterFunction":false,"title":"Production Credits | Greg Goad"},"Latest News Articles":{"css":false,"js":false,"cssLoaded":true,"jsLoaded":true,"html":"<h1 class=\"fishTextBacker\">Recent News<\/h1>\n<figure class=\"perspectiveFixers\">\n<div class=\"coinImage coinSpin\" onclick=\"FastXSpin(this); \" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/A-Man-and-His-Paper\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/256x256.png 1x, \/media\/images\/A-Man-and-His-Paper\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/128x128.png 1x, \/media\/images\/A-Man-and-His-Paper\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/64x64.png 1x, \/media\/images\/A-Man-and-His-Paper\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/A-Man-and-His-Paper\/32x32.png 1x, \/media\/images\/A-Man-and-His-Paper\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/A-Man-and-His-Paper\/source.png\" alt=\"A man in a Gatsby hat reading the newspaper at the kitchen table\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>Serious People read Serious News\n<\/figcaption>\n<\/figure>\n<div class=\"fishTextBacker\">\n<div id=\"latestNewsWrapper\"><\/div><script>\r\n\t\t\t\tif(DYNAMICSECTIONDATA['blog-news'].data){\r\n\t\t\t\t\tDYNAMICSECTIONDATA['blog-news'].HandleData(document.getElementById('latestNewsWrapper'));\r\n\t\t\t\t}else{\r\n\t\t\t\t\tvar config={method:'GET'};\r\n\t\t\t\t\tif(config.method === 'POST'){config.body=DYNAMICSECTIONDATA['blog-news'].ReqBody();}\r\n\t\t\t\t\tRegularFetch('\/dynamicSections_\/blog-news.php',config,'json',function(jsn){\r\n\t\t\t\t\t\tDYNAMICSECTIONDATA['blog-news'].data=jsn.data;\r\n\t\t\t\t\t\tDYNAMICSECTIONDATA['blog-news'].HandleData(document.getElementById('latestNewsWrapper'));\r\n\t\t\t\t\t});\r\n\t\t\t\t\t_el.APPEND(document.getElementById('latestNewsWrapper'),[\r\n\t\t\t\t\t\t_el.CREATE('div','','DynamicSection-Loading',{},[\r\n\t\t\t\t\t\t\t_el.CREATE('span','','',{},['X']),\r\n\t\t\t\t\t\t\t_el.CREATE('span','','',{},['Loading Section']),\r\n\t\t\t\t\t\t\t_el.CREATE('span','','',{},['X'])\r\n\t\t\t\t\t\t])\r\n\t\t\t\t\t]);\r\n\t\t\t\t\t\r\n\t\t\t\t}\r\n\t\t\t<\/script>\n<\/div>\n\n<div class=\"leaveSpace fishTextBacker\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"latest-news\/","igniterFunction":false,"title":"Latest News | Greg Goad"},"Social Media":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"fishTextBacker\">Social Media<\/h1>\n<figure class=\"leaveSpace perspectiveFixers\">\n<div class=\"coinImage coinSpin\" onclick=\"FastXSpin(this); \" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Surfs-Up\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Surfs-Up\/256x256.png 1x, \/media\/images\/Surfs-Up\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Surfs-Up\/128x128.png 1x, \/media\/images\/Surfs-Up\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Surfs-Up\/64x64.png 1x, \/media\/images\/Surfs-Up\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Surfs-Up\/32x32.png 1x, \/media\/images\/Surfs-Up\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Surfs-Up\/source.png\" alt=\"An impressionist representation of a woman on a surfboard, displayed on a tablet, and behind the tablet is water on the left and fire on the right.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption>The good of social media. Don't miss out.\n<\/figcaption>\n<\/figure>\n<h2 class=\"fishTextBacker\">Keep in Touch<\/h2>\n\n<div class=\"fishTextBacker leaveSpace\">\n<h3 class=\"parHeading\">Social Media Links<\/h3>\n<h4 class=\"subHeading\">(Open in a New Window)<\/h4>\n<ul class=\"\">\n   <li><a class=\"invisiAnchors\" href=\"https:\/\/facebook.com\/greggoad.net\" target=\"_BLANK\">\n   <span class=\"socialLogos\"><picture><source srcset=\"\/media\/images\/Facebook-Logo\/521x521.png\" media=\"(min-width:2605px)\" type=\"image\/png\" width=\"521\" height=\"521\" \/>\n<source srcset=\"\/media\/images\/Facebook-Logo\/260x260.png 1x, \/media\/images\/Facebook-Logo\/521x521.png 2x\" media=\"(min-width:1300px)\" type=\"image\/png\" width=\"260\" height=\"260\" \/>\n<source srcset=\"\/media\/images\/Facebook-Logo\/130x130.png 1x, \/media\/images\/Facebook-Logo\/260x260.png 2x\" media=\"(min-width:650px)\" type=\"image\/png\" width=\"130\" height=\"130\" \/>\n<source srcset=\"\/media\/images\/Facebook-Logo\/65x65.png 1x, \/media\/images\/Facebook-Logo\/130x130.png 2x\" media=\"(min-width:325px)\" type=\"image\/png\" width=\"65\" height=\"65\" \/>\n<source srcset=\"\/media\/images\/Facebook-Logo\/32x32.png 1x, \/media\/images\/Facebook-Logo\/65x65.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Facebook-Logo\/source.png\" alt=\"The Facebook Logo\" width=\"2084\" height=\"2084\" \/><\/picture><\/span>Facebook<\/a><\/li>\n   <li><a class=\"invisiAnchors\" href=\"https:\/\/www.youtube.com\/channel\/UCk-Fs7cD4_AS8aRHhgf-dQQ\" target=\"_BLANK\">\n   <span class=\"socialLogos\"><picture><source srcset=\"\/media\/images\/Youtube-Logo\/512x512.png\" media=\"(min-width:2560px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Youtube-Logo\/256x256.png 1x, \/media\/images\/Youtube-Logo\/512x512.png 2x\" media=\"(min-width:1280px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Youtube-Logo\/128x128.png 1x, \/media\/images\/Youtube-Logo\/256x256.png 2x\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Youtube-Logo\/64x64.png 1x, \/media\/images\/Youtube-Logo\/128x128.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Youtube-Logo\/32x32.png 1x, \/media\/images\/Youtube-Logo\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Youtube-Logo\/source.png\" alt=\"The YouTube Logo\" width=\"1024\" height=\"1024\" \/><\/picture><\/span>YouTube<\/a><\/li>\n\n<\/ul>\n<\/div>\n<div class=\"fishTextBacker leaveSpace\">\n<h2>Or \n<a href=\"\/contact\" class=\"invisiAnchors\" onclick=\"VCR.main.EventCHANGE(event,'Contact');\">\n<span class=\"inlineContinueButtons\">\n Contact Me\n<\/span>\n<\/a>\n Directly\n<\/h2>\n<\/div>\n\n<div class=\"fishTextBacker leaveSpace leaveSpaceAfter\">\n<h3 class=\"parHeading\">Around the Net<\/h3>\n<h4 class=\"subHeading\">(Open in a New Window)<\/h4>\n<ul class=\"\">\n   <li><a class=\"invisiAnchors\" href=\"https:\/\/ggHireMe.com\" target=\"_BLANK\">\n   <span class=\"socialLogos\"><picture><source srcset=\"\/media\/images\/Regal-G\/512x512.png\" media=\"(min-width:2560px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/256x256.png 1x, \/media\/images\/Regal-G\/512x512.png 2x\" media=\"(min-width:1280px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/128x128.png 1x, \/media\/images\/Regal-G\/256x256.png 2x\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/64x64.png 1x, \/media\/images\/Regal-G\/128x128.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Regal-G\/32x32.png 1x, \/media\/images\/Regal-G\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Regal-G\/source.png\" alt=\"A Regal G in gold.\" width=\"1024\" height=\"1024\" \/><\/picture><\/span>My Programming Portfolio<\/a><\/li>\n   <li><a class=\"invisiAnchors\" href=\"https:\/\/github.com\/ggoad\" target=\"_BLANK\">\n   <span class=\"socialLogos\"><picture><source srcset=\"\/media\/images\/gitHub-Invertocat\/115x112.png\" media=\"(min-width:575px)\" type=\"image\/png\" width=\"115\" height=\"112\" \/>\n<source srcset=\"\/media\/images\/gitHub-Invertocat\/57x55.png 1x, \/media\/images\/gitHub-Invertocat\/115x112.png 2x\" media=\"(min-width:285px)\" type=\"image\/png\" width=\"57\" height=\"55\" \/>\n<source srcset=\"\/media\/images\/gitHub-Invertocat\/28x27.png 1x, \/media\/images\/gitHub-Invertocat\/57x55.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"28\" height=\"27\" \/>\n<img src=\"\/media\/images\/gitHub-Invertocat\/source.png\" alt=\"The github invertocat\" width=\"230\" height=\"225\" \/><\/picture><\/span>GitHub<\/a><\/li>\n<\/ul>\n<\/div>\n\n<figure class=\"perspectiveFixers\">\n<div class=\"coinImage\" onclick=\"FastXSpin(this);\" role=\"button\" tabindex=\"0\" onkeydown=\"AccKeydown(event, this);\">\n<picture><source srcset=\"\/media\/images\/Telephone\/512x512.png\" media=\"(min-width:640px)\" type=\"image\/png\" width=\"512\" height=\"512\" \/>\n<source srcset=\"\/media\/images\/Telephone\/256x256.png 1x, \/media\/images\/Telephone\/512x512.png 2x\" media=\"(min-width:320px)\" type=\"image\/png\" width=\"256\" height=\"256\" \/>\n<source srcset=\"\/media\/images\/Telephone\/128x128.png 1x, \/media\/images\/Telephone\/256x256.png 2x\" media=\"(min-width:160px)\" type=\"image\/png\" width=\"128\" height=\"128\" \/>\n<source srcset=\"\/media\/images\/Telephone\/64x64.png 1x, \/media\/images\/Telephone\/128x128.png 2x\" media=\"(min-width:80px)\" type=\"image\/png\" width=\"64\" height=\"64\" \/>\n<source srcset=\"\/media\/images\/Telephone\/32x32.png 1x, \/media\/images\/Telephone\/64x64.png 2x\" media=\"(min-width:1px)\" type=\"image\/png\" width=\"32\" height=\"32\" \/>\n<img src=\"\/media\/images\/Telephone\/source.png\" alt=\"A phone waiting to be answered.\" width=\"1024\" height=\"1024\" \/><\/picture>\n<\/div>\n<figcaption class=\"fishTextBacker\">Whatever suits you.\n<\/figcaption>\n<\/figure>\n\n\n<div class=\"fishTextBacker leaveSpace\">\n<div class=\"jumpAroundWrapper\"><h2>Jump Around the Site<\/h2> <div> <a class=\"invisiAnchors\" href=\"\/music\" onclick=\"VCR.main.EventCHANGE(event, 'Music');\"><div class=\"continueButtons\"> Music <\/div><\/a><a class=\"invisiAnchors\" href=\"\/math\" onclick=\"VCR.main.EventCHANGE(event, 'Math');\"><div class=\"continueButtons\"> Math <\/div><\/a><a class=\"invisiAnchors\" href=\"\/software\" onclick=\"VCR.main.EventCHANGE(event, 'Software');\"><div class=\"continueButtons\"> Software <\/div><\/a> <br> <span>(These buttons will take you to new sections)<\/span> <\/div><\/div>\n<\/div>","url":"social-media","igniterFunction":false,"title":"Social Media | Greg Goad"},"My Salvation In Christ":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1 class=\"fishTextBacker\">Jesus Turned my Life Around<\/h1>\n<article class=\"cloudTextBacker\">\n<h2>Dragging the Dirt<\/h2>\n<p>\nAt a time in my life when I was at my lowest, Jesus appeared in my life and gave me a direction.\n<\/p>\n<p>\nI was hurting... My family had disintegrated. I had no idea what I was going to do. It turned out that one of my close friends had a house that was vacant. Well, more like abandoned. I asked to stay there until I figured out my next step. He said I could, and when I got there, it was in the state you'd think an abandoned house would be. \n<\/p>\n<p>\nI started cleaning: starting with the living room, then the bathroom, then the kitchen, and then the bedroom. It was a massive undertaking that had to be done. \n<\/p>\n<p>\n\nI was so thankful for a place to stay. My friend offered to take me out to a fancy restaurant to thank me for cleaning his house. We made our way on down the road, and passed a church with a sign saying 'community dinner'. We stopped at the church, instead of heading on to the restaurant in the city. \n<\/p>\n<p>\nMy friend brought in his guitar (we're musicians). We ate, and played a song or two. The pastor said they needed a piano player. It's something I've always wanted to do. I auditioned the next week, and committed to my service of the Lord. I'm so proud to use my gift in a way that glorifies God.\n<\/p>\n<h2>The Best Day of my Life<\/h2>\n<p>\nI found a home church that day, and since then I've become closer and closer to God in my service to Him. I love my life close to God, and it has protected me from making choices that were destructive to my life. I thank God every day for the life he has given me.\n<\/p>\n<h2>My Witness to You<\/h2>\n<p>\nNo matter what you are guilty of, there is forgiveness for you in the eyes of Jesus.\nPaul was persecuting the followers of Jesus when he was called into service as an apostle: there's nothing you've done that exceeds the transgressions of Paul.\nYou do not have to clean your life up to be close to Jesus: instead, give your life to Jesus and He will clean it up for you. \nThere is an unrivaled peace waiting for you: cast your cares upon the Lord.\n<\/p>\n<p>\nNo man can judge you, but God will, and that's between you and God.\nWe all have things present in our life that are wrong and against God. It's in our nature as humans to sin.\nYour wrongs are no worse than mine (we are all sinners): but they're still wrong, as are mine. \nThe presence of the wrong is why we need Jesus. He will show you what's wrong with your life, give you the power to change it, and forgive you for falling before you knew the difference.\n<\/p>\n<\/article>","url":"my-salvation-in-christ","igniterFunction":false,"title":"My Christian Salvation | Greg Goad"},"siteNav":{"css":false,"js":false,"cssLoaded":false,"jsLoaded":false,"html":"<h1>Select a Page<\/h1><nav><a href=\"\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Home&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Home\" >Home<\/div><\/a><a href=\"\/music\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Music&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Music\" >Music<\/div><\/a><a href=\"\/software\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Software&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Software\" >Software<\/div><\/a><a href=\"\/math\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Math&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Math\" >Math<\/div><\/a><a href=\"\/jammaday\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Jammaday&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Jammaday\" >Jammaday<\/div><\/a><a href=\"\/mochobo\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Mochobo&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Mochobo\" >Mochobo<\/div><\/a><a href=\"\/factoring\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Factoring&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Factoring\" >Factoring<\/div><\/a><a href=\"\/unbalanced-algebra\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Unbalanced Algebra&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Unbalanced-Algebra\" >Unbalanced Algebra<\/div><\/a><a href=\"\/tech-stack\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Tech Stack&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Tech-Stack\" >Tech Stack<\/div><\/a><a href=\"\/apps-and-libraries\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Apps and Libraries&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Apps-and-Libraries\" >Apps and Libraries<\/div><\/a><a href=\"\/waa\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Web Apps Actualized&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Web-Apps-Actualized\" >Web Apps Actualized<\/div><\/a><a href=\"\/contact\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Contact&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Contact\" >Contact<\/div><\/a><a href=\"\/credits\/\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Credits&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Credits\" >Credits<\/div><\/a><a href=\"\/social-media\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;Social Media&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-Social-Media\" >Social Media<\/div><\/a><a href=\"\/my-salvation-in-christ\" onclick=\"VCR.main.MainButtonCHANGE(this.children[0],event,&#039;My Salvation In Christ&#039;);\" ><div class=\"basicNavButton\" id=\"viewButton-My-Salvation-In-Christ\" >My Salvation In Christ<\/div><\/a><a href=\"\/news\" ><div class=\"basicNavButton\" >News<\/div><\/a><a href=\"\/privacy-policy.html\" ><div class=\"basicNavButton\" id=\"viewButton-PrivacyPolicy\" >Privacy Policy<\/div><\/a><\/nav>","url":"siteNav","igniterFunction":false,"title":"Site Navigation | Greg Goad"}};



var VCR={};
VCR.main=new VC((function(){var osc=false; return function(){
			osc=!osc;
			var id="contentTarget1";
			if(osc){id="contentTarget2";}
			return document.getElementById(id);
		};})(),{},{});
VCR.main.REGISTER_view('Home', VCR.main.BasicProjectView('Home'));
VCR.main.REGISTER_view('Music', VCR.main.BasicProjectView('Music'));
VCR.main.REGISTER_view('Software', VCR.main.BasicProjectView('Software'));
VCR.main.REGISTER_view('Math', VCR.main.BasicProjectView('Math'));
VCR.main.REGISTER_view('Jammaday', VCR.main.BasicProjectView('Jammaday'));
VCR.main.REGISTER_view('Mochobo', VCR.main.BasicProjectView('Mochobo'));
VCR.main.REGISTER_view('Factoring', VCR.main.BasicProjectView('Factoring'));
VCR.main.REGISTER_view('Unbalanced Algebra', VCR.main.BasicProjectView('Unbalanced Algebra'));
VCR.main.REGISTER_view('Tech Stack', VCR.main.BasicProjectView('Tech Stack'));
VCR.main.REGISTER_view('Apps and Libraries', VCR.main.BasicProjectView('Apps and Libraries'));
VCR.main.REGISTER_view('Web Apps Actualized', VCR.main.BasicProjectView('Web Apps Actualized'));
VCR.main.REGISTER_view('Contact', VCR.main.BasicProjectView('Contact'));
VCR.main.REGISTER_view('Credits', VCR.main.BasicProjectView('Credits'));
VCR.main.REGISTER_view('Latest News Articles', VCR.main.BasicProjectView('Latest News Articles'));
VCR.main.REGISTER_view('Social Media', VCR.main.BasicProjectView('Social Media'));
VCR.main.REGISTER_view('My Salvation In Christ', VCR.main.BasicProjectView('My Salvation In Christ'));
VCR.main.REGISTER_view('siteNav', VCR.main.BasicProjectView('siteNav'));
APPBUTTONDATA={"back":{"Home":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Music":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Software":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Math":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Jammaday":{"destination":"\/music\/","name":"Music","ariaLabel":"Back to Music","title":"Back to Music"},"Contact":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Credits":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Latest News Articles":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Social Media":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"My Salvation In Christ":{"destination":"\/","name":"Home","ariaLabel":"Back to Home","title":"Back to Home"},"Mochobo":{"destination":"\/music\/","name":"Music","ariaLabel":"Back to Music","title":"Back to Music"},"Tech Stack":{"destination":"\/software\/","name":"Software","ariaLabel":"Back to Software","title":"Back to Software"},"Apps and Libraries":{"destination":"\/software\/","name":"Software","ariaLabel":"Back to Software","title":"Back to Software"},"Web Apps Actualized":{"destination":"\/software\/","name":"Software","ariaLabel":"Back to Software","title":"Back to Software"},"Factoring":{"destination":"\/math\/","name":"Math","ariaLabel":"Back to Math","title":"Back to Math"},"Unbalanced Algebra":{"destination":"\/math\/","name":"Math","ariaLabel":"Back to Math","title":"Back to Math"},"siteNav":{"destination":"","name":""}}};

DYNAMICSECTIONDATA={'blog-news':{
				HandleData:function(target){
					var dat=this.data;
					_el.EMPTY(target);
					_el.APPEND(target,_el.CREATE('div','','',{}, [_el.CREATE('div','','DynamicBlog-Header',{}, ['Latest News Articles'].filter(function(a){return a;})),...dat["articles"].map(function(eac){ return _el.CREATE('a','','invisiAnchors',{'target':'dynamicBlogReader','href':'/news/'+eac["slug"]+''}, [_el.CREATE('div','','DynamicBlog-Card',{}, [_el.CREATE('div','','',{}, [''+eac["title"]].filter(function(a){return a;}))].filter(function(a){return a;}))].filter(function(a){return a;}));})].filter(function(a){return a;})));
				},
				ReqBody:function(){return new FormData();}
			}};



/*END VCR2_basic*/

/*START clipboardLib */
_ClipLib={
   Copy:function(txt, onSuccess, onFail){
     onFail=onFail || function(txt){console.error(txt);};
     onSuccess=onSuccess || function(txt){console.log(txt);};
     if (navigator.clipboard) {
       navigator.clipboard.writeText(txt)
         .then(() => {
           onSuccess('Text has been copied to the clipboard');
         })
         .catch(err => {
           onFail('Unable to copy text to the clipboard:');
         });
     } else {
        // Create a new textarea element to temporarily hold the text
        const textarea = document.createElement('textarea');
        textarea.value = txt;

        // Make the textarea invisible
        textarea.style.position = 'absolute';
        textarea.style.left = '-9999px';
        textarea.style.visibility="hidden";

        // Append the textarea to the document
        document.body.appendChild(textarea);

        // Select the text inside the textarea
        textarea.select();

        try {
          // Execute the copy command
          document.execCommand('copy');
          onSuccess('Text has been copied to the clipboard');
        } catch (err) {
          onFail('Unable to copy text to the clipboard:');
        } finally {
          // Remove the textarea from the DOM
          document.body.removeChild(textarea);
        }
     
     }

   },
   CopySoftNotification:function(txt){
      this.Copy(txt, function(txt){SoftNotification.Render(txt);}, function(txt){SoftNotification.Render(txt);});
   }
};
/*END clipboardLib*/

/*START cookieManager */
/*// this is normaly hooked into a template pipeline
// ggdotnetcookiemanager can be whatever you want it to be
// {grecaptcha:{
	name:'grecaptcha',
	readableName:'Google Recaptcha', 
	category:'3rd Party',
	description:_el.CREATE('div','','',{},[
		'We use this 3rd party service provided by Google to guard against bot attacks. Several cookies are set by google to detect if the user is a bot or not. Google would have access to any public data about your browsing session.',
		_el.CREATE('br'),
		_el.CREATE('span','','',{},["Visit Google's ",_el.CREATE('a','','',{href:"https://policies.google.com/privacy"},["Privacy Policy"]), _el.CREATE('br')," and ",_el.CREATE('a','','',{href:"https://policies.google.com/terms"},["Terms of Service"])])
	]),
	added:false,
	level:false, 
	listeners:[],
	adder:function(onsucceed, onfail){
		_el.APPEND(document.head, _el.CREATE("script","","",{onerror:function(){
			onfail();
		},onload:function(){
			onsucceed();
		},src:"https://www.google.com/recaptcha/api.js?render=6LdKd-AnAAAAACf_hGED7w0l5gTtFSM-191RLTiy"}));
	}
},youtube:{
	name:'youtube',
	readableName:'YouTube', 
	category:'3rd Party',
	description:_el.CREATE('div','','',{},[
		'When we embed YouTube videos, YouTube will be able to see some data about your browsing session.',
		_el.CREATE('br'),
		_el.CREATE('span','','',{},["Visit Google's ",_el.CREATE('a','','',{href:"https://policies.google.com/privacy"},["Privacy Policy"]), _el.CREATE('br')," and ",_el.CREATE('a','','',{href:"https://policies.google.com/terms"},["Terms of Service"])])
	]),
	added:false,
	level:false, 
	listeners:[],
	adder:function(onsucceed, onfail){
		onsucceed();
	}
}} is the list of cookies you can ask permission for
// 	see the comment above site cookies for examples
*/
CookieManager=(function(){ 
	var permissions=localStorage.getItem('ggdotnetcookiemanager');

	var ret={
                autoRender:true,
                allowAllOnPlaceholder:false,
                localStorageIndex:'ggdotnetcookiemanager',
                /*siteCookies:{
                   test:{
                      name:'test',
                      readableName:'Test Cookie', 
                      category:'Cookies for Testing',
                      description:'Yo. this is just a test. We are seeing if it works',
                      added:false,
                      level:false, 
                      listeners:[],
                      adder:function(){
                         console.log('added');
                      }
                   },
                   grecaptcha:{
                      name:'grecaptcha',
                      readableName:'Google Recaptcha', 
                      category:'3rd Party',
                      description:'We use this 3rd party service provided by google to guard against bot attacks.',
                      added:false,
                      level:false, 
                      listeners:[],
                      adder:function(){
                         console.log('grecaptcah added');
                      }
                   },
                   youtube:{
                      name:'youtube',
                      readableName:'Youtube Player', 
                      category:'3rd Party',
                      description:'When we embed the youtube player, certain information about your browsing session will be shared with Google',
                      added:false,
                      level:false, 
                      listeners:[],
                      adder:function(){
                         console.log('youtube added');
                      }
                   },
                },*/
				siteCookies:{grecaptcha:{
	name:'grecaptcha',
	readableName:'Google Recaptcha', 
	category:'3rd Party',
	description:_el.CREATE('div','','',{},[
		'We use this 3rd party service provided by Google to guard against bot attacks. Several cookies are set by google to detect if the user is a bot or not. Google would have access to any public data about your browsing session.',
		_el.CREATE('br'),
		_el.CREATE('span','','',{},["Visit Google's ",_el.CREATE('a','','',{href:"https://policies.google.com/privacy"},["Privacy Policy"]), _el.CREATE('br')," and ",_el.CREATE('a','','',{href:"https://policies.google.com/terms"},["Terms of Service"])])
	]),
	added:false,
	level:false, 
	listeners:[],
	adder:function(onsucceed, onfail){
		_el.APPEND(document.head, _el.CREATE("script","","",{onerror:function(){
			onfail();
		},onload:function(){
			onsucceed();
		},src:"https://www.google.com/recaptcha/api.js?render=6LdKd-AnAAAAACf_hGED7w0l5gTtFSM-191RLTiy"}));
	}
},youtube:{
	name:'youtube',
	readableName:'YouTube', 
	category:'3rd Party',
	description:_el.CREATE('div','','',{},[
		'When we embed YouTube videos, YouTube will be able to see some data about your browsing session.',
		_el.CREATE('br'),
		_el.CREATE('span','','',{},["Visit Google's ",_el.CREATE('a','','',{href:"https://policies.google.com/privacy"},["Privacy Policy"]), _el.CREATE('br')," and ",_el.CREATE('a','','',{href:"https://policies.google.com/terms"},["Terms of Service"])])
	]),
	added:false,
	level:false, 
	listeners:[],
	adder:function(onsucceed, onfail){
		onsucceed();
	}
}},
                SoftAdd:function(name){
                   if(this.siteCookies[name].listeners.length){this.Add(name);}
                },
                Add:function(name){
                   var sc=this.siteCookies[name];
                   
                   sc.adder(function(){
                      
                      sc.added=true;
                      sc.listeners.forEach(function(l){l();});
                      sc.listeners=[];
                      if(sc.level === 'once'){CookieManager.SetPermission(name,'none');}
                   },function(msg){msg=msg||''; if(msg){msg=' '+msg;}sc.added=false;SoftNotification.Render("Failed to Add Cookie"+msg);});
                },
                PermissionPlaceholder:function(cooks, reason){
                   var t=this;
                   if(!Array.isArray(cooks)){cooks=[cooks];}
                   return _el.CREATE('div','','CookieManager-PermissionPlaceholder',{},[
                      _el.CREATE('div','','',{},["A cookie is required ", reason]),
                      _el.CREATE('button','','',{
                         onclick:function(e){
                            _el.CancelEvent(e);
                            t.SetPermissionArr(cooks,"any");
                         }
                      },["Allow"]),
                      _el.CREATE('button','','',{
                         onclick:function(e){
                            _el.CancelEvent(e);
                            t.SetPermissionArr(cooks,"once");
                         }
                      },["Allow Once"]),
                      ((!this.autoRender && this.allowAllOnPlaceholder) ?  
                         _el.CREATE('button','','',{
                            onclick:function(e){
                               _el.CancelEvent(e);
                               t.SetAllPermission('any');
                            }
                         },["Allow All Cookies"]) : ''
                      ),
                      (this.autoRender ? '' : 
                         _el.CREATE('button','','',{
                            onclick:function(e){
                               _el.CancelEvent(e);
                               t.Render();
                            }
                         },["Manage Cookies"])
                      ),
                      _el.CREATE('br'),
                      _el.CREATE('details','','',{},[
                         _el.CREATE('summary','','',{},[""]),
                         ...cooks.map(c=>{
                            var d=t.siteCookies[c].description;
                            if(d.cloneNode){d=d.cloneNode(true);}
                            return _el.CREATE('div','','CookieManager-CookieDetails',{},[
                              _el.CREATE('h3','','',{},[t.siteCookies[c].readableName+" ("+t.siteCookies[c].category+")"]),
                              _el.CREATE('p','','',{},[d])
                            ]);
                         })
                      ])
                   ]);
                },
		GetPermission:function(name, el, success, reason){
                        var t=this;
                        reason= reason || "for this section to function";
                        if(!Array.isArray(name)){
                           name=[name];
                        }
                        name.forEach(function(n){if(!t.siteCookies[n]){throw new Error("Could not find cookie. "+n);}});

                        if(name.reduce(function(a,n){return a && t.siteCookies[n].added;}, true)){
                            success();
                            return true;
                        }
                        var blocked=false;
                        var allNone=true;
                        name.forEach(function(n){
                           if(['once', 'any'].indexOf(t.siteCookies[n].level) > -1){
                              t.Add(n);
                              return;
                           }
                           blocked=true;
                           if(t.siteCookies[n].level !== 'none'){
                              allNone=false;
                           }
                        });

                        if(blocked){
                            
                            _el.APPEND(el, this.PermissionPlaceholder(name, reason));
                            this.siteCookies[name].listeners.push(this.Emptier(el, success, name));
                            if(!allNone && this.autoRender){
                               this.Render(true);
                            }
                            return;
                        }
                        success();
		},
                Emptier:function(el, f,nameArr){
                   var t=this;
                   return function(){if(!nameArr.reduce(function( acc,n){return acc && t.siteCookies[n].added;},true)){return; }_el.EMPTY(el);f();}
                },
                CloseRender:function(){
                   document.documentElement.style.removeProperty("padding-bottom");
                   _el.REMOVE(document.querySelector("#CookieManager-Interface"));
                },
		Render:function(spec){
                        var text="Cookie Management";
                        if(spec){text="This section of the website uses cookies.";}
                        var t=this;
                        if(document.querySelector("#CookieManager-Interface")){return;}
                        var interface;
                        var ext;
                        var manageButton;
                        var noCloseAfterSave=false;
                        var closer;
			_el.APPEND(this.GetTarget(), interface=_el.CREATE('div','CookieManager-Interface','',{},[
                           _el.CREATE('div','CookieManager-CloseHolder','',{},[
                              closer=_el.CREATE('button','','',{onclick:function(){
                                  var sub;
                                  if((sub=document.querySelector('#CookieManager-Submit'))){sub.dispatchEvent(new Event('click'));}
                                  t.CloseRender();
                              }},['X'])
                           ]),
                           _el.CREATE('h3','','',{},[text]),
                           _el.CREATE('div','CookieManager-ButtonHold','',{},[
                              _el.CREATE('button','','',{
                                  onclick:function(e){
                                     _el.CancelEvent(e);
                                     t.SetAllPermission('any');
                                     t.CloseRender();
                                  }
                              },["Allow All"]),
                              _el.CREATE('button','','',{
                                  onclick:function(e){
                                     _el.CancelEvent(e);
                                     t.SetAllPermission('none');
                                     t.CloseRender();
                                  }
                              },["Block All"]),
                              manageButton=_el.CREATE('button','','',{
                                 onclick:function(e){
                                    function RenderSubmitter(){
                                       if((document.querySelector("#CookieManager-Submit"))){
                                          return;
                                       }
                                       _el.APPEND(ext, _el.CREATE("div",'CookieManager-Submit','',{onclick:function(){
                                          
                                           var list=Array.from(document.querySelectorAll('.CookieManagerSetting'));
                                           list.forEach(function(l){
                                              var n=l.id.replace("CookieManagerSetting-",''); 
                                              var set=(Array.from(l.querySelectorAll('[type="radio"]')).filter(function(e){return e.checked;})[0] || {}).value;
                                              if(set){t.SetPermission(n, set);} 
                                           });
                                           if(!noCloseAfterSave){
                                              t.CloseRender();
                                           }else{noCloseAfterSave=false;}
                                       }},["Save Cookie Settings"]));
                                       
                                    }
                                       var ht=interface.scrollHeight;
                                       interface.style.height=ht+"px";
                                       interface.style.overflow='hidden';
                                       setTimeout(function(){interface.style.height="100%"; setTimeout(function(){interface.style.removeProperty('overflow');}, 501);},1);
                                       
                                    this.style.display='none';
                                    var cats={};
                                    var sc=t.siteCookies;
                                    _el.EMPTY(ext);
                                    _el.APPEND(ext, [_el.CREATE('button','','',{onclick:function(){
                                     
                                      var sub;
                                      if((sub=document.querySelector('#CookieManager-Submit'))){noCloseAfterSave=true;sub.dispatchEvent(new Event('click'));}
                                      _el.EMPTY(ext);ext.onchange='';
                                      interface.style.height=ht+'px';
                                      interface.style.overflow='hidden';
                                      setTimeout(function(){interface.style.removeProperty('overflow');interface.style.removeProperty('height');manageButton.style.removeProperty('display');},501);
                                       
                                      
                                    }},["Hide Details"]),_el.CREATE('br')]);
                                    ext.onchange=function(e){
                                       RenderSubmitter();
                                    };
                                    for(var mem in sc)
                                    {
                                       if(!cats[sc[mem].category]){cats[sc[mem].category]=[];}cats[sc[mem].category].push(sc[mem]);
                                    }
                                    for(var mem in cats)
                                    {
                                       _el.APPEND(ext, _el.CREATE('div','','CookieManager-Manager-Category',{},[
                                          _el.CREATE('h4','','',{},[mem]),
                                          _el.CREATE('div','','',{
                                             onchange:function(e){
                                                
                                             }
                                          },[
                                             _el.CREATE('label','','',{},[
                                                "Allow: ",
                                                _el.CREATE('input','','CookieManager-Category CookieManager-Category-RadioAllow',{type:'radio', name:'cookieManager-category-'+mem, onchange:function(){
                                                    var list=this.parentNode.parentNode.querySelectorAll('.CookieManager-Cookie-RadioAllow');
                                                    list.forEach(function(l){l.checked=true;});
                                                }, checked:cats[mem].reduce(function(acc, curr){return acc && curr.level === 'any';},true)})
                                             ]),
                                             _el.CREATE('label','','',{},[
                                                "Block: ",
                                                _el.CREATE('input','','CookieManager-Category CookieManager-Category-RadioBlock',{type:'radio', name:'cookieManager-category-'+mem, onchange:function(){
                                                    var list=this.parentNode.parentNode.querySelectorAll('.CookieManager-Cookie-RadioBlock');
                                                    list.forEach(function(l){l.checked=true;});
                                                }, checked:cats[mem].reduce(function(acc, curr){return acc && curr.level === 'none';},true)})
                                             ]),
                                             _el.CREATE('label','','',{},[
                                                "Allow Once: ",
                                                _el.CREATE('input','','CookieManager-Category CookieManager-Category-RadioAllowOnce',{type:'radio', name:'cookieManager-category-'+mem, onchange:function(){
                                                    var list=this.parentNode.parentNode.querySelectorAll('.CookieManager-Cookie-RadioAllowOnce');
                                                    list.forEach(function(l){l.checked=true;});
                                                }, checked:cats[mem].reduce(function(acc, curr){return acc && curr.level === 'once';},true)})
                                             ]),
                                             _el.CREATE('br'),
                                             _el.CREATE('details','','',{onchange:function(){Array.from(this.parentNode.querySelectorAll('.CookieManager-Category')).forEach(function(a){a.checked=false;});}},[
                                                _el.CREATE('summary'),
                                                ...cats[mem].map(function(c){
                                                   return _el.CREATE('div','','CookieManager-Manager-Cookie',{},[
                                                      _el.CREATE('h4','','',{},[c.readableName]),
                                                      _el.CREATE('p','','',{},[c.description]),
                                                      _el.CREATE('div','CookieManagerSetting-'+c.name,'CookieManagerSetting',{},[
                                                         _el.CREATE('label','','',{},[
                                                           "Allow: ",
                                                            _el.CREATE('input','','CookieManager-Cookie CookieManager-Cookie-RadioAllow',{type:'radio', name:'cookieManager-cookie-'+c.name,value:'any',checked:(c.level === 'any')})
                                                         ]),
                                                         _el.CREATE('label','','',{},[
                                                           "Block: ",
                                                            _el.CREATE('input','','CookieManager-Cookie CookieManager-Cookie-RadioBlock',{type:'radio', name:'cookieManager-cookie-'+c.name, value:'none', checked:c.level === 'none'})
                                                         ]),
                                                         _el.CREATE('label','','',{},[
                                                           "Allow Once: ",
                                                            _el.CREATE('input','','CookieManager-Cookie CookieManager-Cookie-RadioAllowOnce',{type:'radio', name:'cookieManager-cookie-'+c.name, value:'once',checked:c.level === 'once'})
                                                         ]),
                                                      ]),
                                                   ])
                                                })
                                             ])
                                          ]),
                                       ]));
                                    }
                                 }
                              },["Manage Cookies"]),
                           ]),
                           ext=_el.CREATE('div','CookieManager-Details','',{},[])
                        ]));
                        var sh=interface.scrollHeight;
                        document.documentElement.style.paddingBottom=sh+"px";
                        interface.style.bottom=(-sh)+"px";
                        
                        setTimeout(function(){interface.style.transition="bottom 500ms, height 500ms"; interface.style.bottom=0; setTimeout(function(){interface.style.removeProperty("transition");interface.style.removeProperty("bottom"); closer.focus();},501);},1);

                     
		},
                SetAllPermission:function(level){
                   for(var mem in this.siteCookies)
                   {
                      this.SetPermission(mem, level,true);
                   }
                   this.WritePermission();
                },
                SetPermissionArr:function(cooks, level){
                   var t=this;
                   cooks.forEach(function(c){t.SetPermission(c, level, true);});
                   this.WritePermission();
                },
		SetPermission:function(name,level, noWrite){
			this.siteCookies[name].level=level;
                        if(level !== 'none'){
                           this.SoftAdd(name);
                        }
                        if(!noWrite){
                           this.WritePermission();
                        }
                        
		},
                WritePermission:function(){
                   var t=this;
                   var keys=Object.keys(this.siteCookies);
                   var entries=keys.filter(function(k){return t.siteCookies[k].level;}).map(function(k){return [k,t.siteCookies[k].level];});
                   var ob=Object.fromEntries(entries);
                   console.log(ob);
                   localStorage.setItem(this.localStorageIndex, JSON.stringify(ob));
                },
		tar:null,
                vc:null,
                GetTarget:function(){
                  return this.tar || (this.vc || {}).currentTarget || document.body;
                },
                REGISTER_VC:function(vc){
                  var t=this;
                  this.vc=vc;
                  VC.REGISTER_changeANDrelease(function(){
                     t.permissionListeners={};
                  });
                }
	};
        if(permissions){
           permissions=JSON.parse(permissions);
           for(var mem in permissions)
           {ret.siteCookies[mem].level=permissions[mem];}
        }
        return ret;
})();


/*END cookieManager*/

/*START elFetch */
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
}
/*END elFetch*/

/*START hist */
_hist={
	incrId:0,
   firstHistory:true,
   uriOb:{},
	url:false,
   logflag:true,
   documentTitle:'',
   globOb:null,
   GRAB_addr:function(){
      if(history && history.state && history.state.VCR){
         var VCRaddr=history.state.VCR;
         for(var mem in VCRaddr)
         {
             VCR[mem].historyChange=true;
             VCR[mem].stagedView=''+VCRaddr[mem].view;
             if(VCRaddr[mem].viewData){
                VCR[mem].PUSH_viewData(VCRaddr[mem].viewData);
             }
         }
      }
	   
   }
};


if(history && history.state && history.state.stateId){
	_hist.incrId=history.state.stateId;
}

if(history && history.pushState){
   VC.prototype.LOG_change=function(){
          var uriOb={};
          
                   
		  for(var mem in VCR)
		  {
			 if(VCR[mem].active && !VCR[mem].config.noLog){
                                var view;
				uriOb[mem]={
                                   view:(view=VCR[mem].currentView)
                                };
                                var vd=VCR[mem][VCR[mem].GET_viewName()].viewData;
                                if(!Object.keys(vd).length){vd=false;}
                                if(vd){
                                   uriOb[mem].viewData=VCR[mem][VCR[mem].GET_viewName()].viewData;
                                }
                                if(VCR[mem].captured){
                                   uriOb[mem].captured=true;
                                }
			 }
		  }
		  var globOb=_hist.globOb || {};
                  if(_hist.logflag){
		     if(!_hist.firstHistory && !_ob.COMPARE(uriOb, _hist.uriOb)){
  		       _hist.incrId++;
			   history.pushState(_hist.lastState=_ob.COMBINE({VCR:uriOb, stateId:_hist.incrId}, globOb),"",_hist.url || undefined);  
		     }else{
   	 		_hist.firstHistory=false;
  
			    history.replaceState(_hist.lastState=_ob.COMBINE({VCR:uriOb, stateId:_hist.incrId},globOb),"", _hist.url || undefined);  
		     }
                     
                  }
                   
			_hist.url=false;
                  _hist.uriOb=uriOb;
                  if(_hist.documentTitle){document.title=_hist.documentTitle; _hist.documentTitle="";}
	  
   };
   onpopstate=function(){
           var state=history.state;
           if(!state){
              history.replaceState(_hist.lastState,'',location.href);
              return;
           }else{
              state=state.VCR;
           }
           _hist.GRAB_addr();
           _hist.logflag=false;
           for(var mem in state)
           {
              if(!state[mem].captured){
                 VCR[mem].CHANGE();
              }
           }
	   _hist.logflag=true;
   };
}else{
   console.warn('no history supported');
}
/*END hist*/

/*START regularFetch */
function RegularFetch( file, config, responseType, responseSuccess,  failFunction){
    config=config || {};
    
    fetch(file,config)
    .then(function(res){
        if(parseInt(res.status) >= 400){
            throw new Error("Server Error: "+res.status);
        }
        return res[responseType]();
    }).then(function(rt){
        if((responseType === 'json' &&  rt.success) || rt === "SUCCESS"){
            responseSuccess(rt);
        }else{
            throw new Error("Processing Problem: "+(rt.msg || rt));
        }
        
    }).catch(function(e){
        console.log(e);
        if(failFunction){
           setTimeout(failFunction, 1);
        }
        if(e.message === 'Failed to fetch'){
            console.log("There was a problem submitting. Possibly a network error. Please try again.");
            return;
        }
        //globalE=e;
        //console.log(structuredClone(e));
        //console.log(JSON.stringify(e));
        console.log("Error "+e.message);
    });
}
/*END regularFetch*/

/*START softNotification */
SoftNotification={
   Render:function(body, fadeOutDur){
      fadeOutDur=fadeOutDur || 1000;
      var r;
      _el.APPEND(document.body, r=_el.CREATE('div','','SoftNotification-Wrapper',{},[
         _el.CREATE('div','','SoftNotification-ActionWrapper',{},[_el.CREATE('button','','',{onclick:function(){_el.REMOVE(this.parentNode.parentNode);}},["X"])]),
         _el.CREATE('div','','SoftNotification-BodyWrapper',{},body)
      ]));
      r.style.opacity='0';
      setTimeout(function(){
         r.style.opacity='1';
         if(fadeOutDur === -1){return;}
         setTimeout(function(){
            r.style.opacity="0";
            setTimeout(function(){_el.REMOVE(r);},501);
         },fadeOutDur+501);
      },1);
   }
};
/*END softNotification*/

/*START startbasic*/ 

/* CORE */

addEventListener(
'load', 
function(){
	VCR.main.currentView=VCR.main.safeMap['Latest News Articles'];
	VCR.main.active=true;
	VCR.main.LOG_change();
	history.scrollRestoration="manual";
		document.addEventListener("scroll", (function(){
			var timeout;
			return function(e){
				clearTimeout(timeout);
				var vcrInd=VCR.main.viewsVisited;
				timeout=setTimeout(function(){
					if(vcrInd !== VCR.main.viewsVisited){return;}
					history.replaceState(_ob.COMBINE(history.state, {lastScroll:""+document.documentElement.scrollTop}),"");
				},100);
				
			}
		})());
});
/*END startbasic*/

/*mainCanvas*/
var canvWrap, mainCanv, mainCtx, mainAniLastTime=0, mainAniFuncts=[], mainAniSaver;



function MainAniFrame(fr){
   mainCanv.height=mainCanv.clientHeight;
   mainCanv.width=mainCanv.clientWidth; 
   if(!fr){fr=1000/60;}
   var elapsed=fr-mainAniLastTime;
   mainAniLastTime=fr;
   var frames=elapsed*60/1000 || 1;
   var curView=VCR.main.GET_viewName();

   if(curView !== mainAniSaver){
      mainAniFuncts.push(AniFamilies[curView](curView));
   }
   mainAniSaver=curView;
   mainCtx.clearRect(0,0,mainCanv.width, mainCanv.height);
   mainAniFuncts=mainAniFuncts.map(function(af){
     return af(af, frames, curView);
   }).filter(function(a){return a;});
   
   if(window.requestAnimationFrame){
      requestAnimationFrame(MainAniFrame);
   }else{
      setTimeout(function(){MainAniFrame();},1000/60);
   }
}
addEventListener('load',function(){
   canvWrap=document.getElementById("canvasWrapper");
   mainCanv=document.getElementById("mainCanvas");
   mainCanv.height=mainCanv.clientHeight;
   mainCanv.width=mainCanv.clientWidth;
   mainCtx=mainCanv.getContext('2d');
   if(window.requestAnimationFrame){
      requestAnimationFrame(MainAniFrame);
   }else{
      setTimeout(function(){MainAniFrame();},1000/60);
   }

   SetGraphics({});
   SetAudio({});
});
addEventListener('resize',function(){
   if(!window.mainCanv){return;}
   setTimeout(function(){
      mainCanv.height=canvWrap.clientHeight;
      mainCanv.width=canvWrap.clientWidth;
   },1);
});
/*animationFamilies*/
AniFamilies={
   'Cubes':function(){
      SetGraphics({page:{
        name:'Diamonds',
        description:'Watch the diamonds float accross the screen',
        interactivity:["Click or Touch the diamonds and see them explode"]
      }});
      function CheckClick(e){
         var x=e.clientX;
         var y=e.clientY;
         cubes.forEach(function(c){
            var scale3=c.scale*3, scale2=c.scale*2, cy=c.y*mainCanv.height/100, cx=c.x;
            c.hit=c.hit || (cy+scale3 >= y && cy-scale3 <= y
              && cx+scale2 >= x && cx-scale2 <= x);
         });
      }
      addEventListener('click', CheckClick);

      var inn=false;
      var snubbedFrames=0;
      var cubes=[];
      
      var maxCubes=10;
      var msPassed=0;

      

      function HitParticle(x,y){
         var r=Math.random()*2*Math.PI;
         this.x=x; this.y=y;
         this.yoffset=0;
         this.xoffset=0;
         this.dirx=Math.sin(r);
         this.diry=Math.cos(r);
         this.scale=Math.random()*4+1;
      }
      HitParticle.prototype.DRAW=function(){
         this.xoffset+=this.dirx*this.scale;
         this.yoffset+=this.diry*this.scale;
         this.scale-=0.1;
         var y=this.y*mainCanv.height/100;
         mainCtx.moveTo(this.x, y);
         mainCtx.arc(this.x+this.xoffset, y+this.yoffset, 2, 0, Math.PI*2);
      };
      function Cube(){
        
        this.y=Math.random()*100;
        this.size=Math.random()*10+1;
        if(Math.floor(Math.random()*2)){
           this.direction=1;
           this.x=-20;
        }else{
           this.direction=-1;
           this.x=mainCanv.clientWidth+20;
        }
        this.speed=0.15+Math.random()*0.5;
        this.scale=3+Math.random()*8;
        this.hitParticles=[];
        this.hitOpacity=1;
      };
      var lockout=false;
      Cube.prototype.DRAW=function(fr){
            var pre;
            var scale=this.scale;
            if(this.hit){
               if(!this.hitParticles.length){
                  this.hitOpacity=1;
                  for(var i=0; i<20; i++)
                  {this.hitParticles.push(new HitParticle(this.x, this.y));}
               }
               mainCtx.save();
               mainCtx.beginPath();

               mainCtx.strokeStyle="rgba(0,128,0,"+this.hitOpacity+")";
               this.hitParticles.forEach(function(hp){
                  hp.DRAW();
               });
               this.hitOpacity-=1/60;
               this.hitOpactiy=Math.max(this.hitOpacity, 0);
               mainCtx.stroke();
               mainCtx.beginPath();
               mainCtx.restore();
               if(this.hitOpacity <=0){
                 return false;
               }
               return this;
            }
            if(!inn){pre=13;}else{pre=1;}
            if(!lockout){
               this.x+=this.direction*(fr*this.speed*pre);
            }else{
               if(!this.lockIt){
                  this.lockIt=1;
                  this.ogY=this.y;
               }
               this.x+=(((mainCanv.width+25)-this.x)/(30-this.lockIt)) || 1;
               if(this.y > 50){
                 
                 this.y=this.ogY-Math.sqrt(this.lockIt)*((this.ogY-50)/5.4777);
               }else{
                 this.y=this.ogY+Math.sqrt(this.lockIt)*((50-this.ogY)/5.4777);
               }
               this.lockIt++;
               if(this.lockIt > 30){return false;}
            }
            var percY=this.y*mainCanv.clientHeight/100;
            var topX=this.x, topY=percY+3*scale;
            var bottomX=this.x, bottomY=percY-3*scale;
            
            var tau=Math.PI*2;
            var pi=Math.PI;
            var baseSinArg=(msPassed/500) % (tau);

            var p1s, p2s, p3s;
            var p1X=Math.sin((p1s=(baseSinArg+tau/3)%tau))*2*scale+this.x, p1Y=percY;
            var p2X=Math.sin((p2s=(baseSinArg+2*tau/3)%tau))*2*scale+this.x, p2Y=percY;
            var p3X=Math.sin((p3s=baseSinArg%tau))*2*scale+this.x, p3Y=percY;
            var sortArr=[[p1X,(p1s+pi/2)%tau], [p2X, (p2s+pi/2)%tau], [p3X,(p3s+pi/2)%tau]];
            sortArr.sort(function(a, b){  
              return a[1]-b[1];
            });
            p1X=sortArr[0][0]; p2X=sortArr[1][0]; p3X=sortArr[2][0];

           
            
            mainCtx.beginPath();

            mainCtx.fillStyle="darkGreen";

            mainCtx.moveTo(p1X, p1Y);
            mainCtx.lineTo(topX, topY);
            mainCtx.lineTo(p3X, p3Y);
            mainCtx.lineTo(bottomX, bottomY);
            mainCtx.lineTo(p1X, p1Y);
            mainCtx.lineTo(p3X, p3Y);
            mainCtx.fill();
            mainCtx.stroke();
            
            mainCtx.beginPath();
            

            mainCtx.moveTo(p2X, p2Y);
            mainCtx.lineTo(topX, topY);
            mainCtx.lineTo(p3X, p3Y);
            mainCtx.lineTo(bottomX, bottomY);
            mainCtx.lineTo(p2X, p2Y);
            mainCtx.lineTo(p3X, p3Y);
            mainCtx.fill();
           
            mainCtx.beginPath();
            mainCtx.moveTo(topX, topY);
            mainCtx.lineTo(p2X, p2Y);
            mainCtx.lineTo(p3X, p3Y);
            mainCtx.moveTo(p2X, p2Y);
            mainCtx.lineTo(bottomX, bottomY);
            if(sortArr[1][0] > sortArr[2][0]){
               mainCtx.lineTo(p3X, p3Y);
               mainCtx.lineTo(topX, topY);
            }
            mainCtx.stroke();

            var dirMult=(lockout ? -1 : 1);
            
            if(this.direction*dirMult === -1){
               if(this.x<-20){return false;}
            }else{
               if(this.x>mainCanv.clientWidth+20){return false;}
            }
            return this;
      };
      return function(self, f, curView){
         msPassed+=f*1000/60;
         if(curView === "Home"){
            if(!inn){
               snubbedFrames++;
               while(cubes.length < 7){cubes.push(new Cube());}
               if(snubbedFrames < 30){return self;}
            }else if(cubes.length<maxCubes){
               if(!Math.floor(Math.random()*(cubes.length**4+5))){
                  cubes.push(new Cube());
               }
            }
         };
         
         mainCtx.save();
         mainCtx.strokeStyle='green';
         
         mainCtx.beginPath();
         if(curView !== "Home" || lockout){
            lockout=true;
            if(!cubes.length){
               removeEventListener('click', CheckClick);
               return false;
            }
         }
         cubes=cubes.map(function(c){return c.DRAW(f);}).filter(function(c){return c;});
         
         
         mainCtx.stroke();
         mainCtx.restore();
         if(snubbedFrames > 80){inn=true;}
         return self;
         
         
         
      }
   },
   
};
/*incrDecrChange*/
VC.prototype.INCR=function(){
    this.CHANGE((this.currentView+1)%(this.views.length-1));
};
VC.prototype.DECR=function(){
    var c=this.currentView-1; 
    if(c<0){c=this.views.length-2;}
    this.CHANGE(c);
};
/*faceAnimationFamily*/
AniFamilies.Face=function(cv){
      SetGraphics({page:{
        name:'Face',
        description:'It\'s like its eyes follow you!',
        interactivity:[
           "He follows your cursor or your finger accross the screen.",
           "If you poke him in the eye, he'll wink at you!"
        ]
      }});
      function Lerp(a,b,by){return a+(b-a)*by;};
         canvWrap.style.borderRadius="47%";
      
      function MouseEv(e){ mouseX=e.clientX; mouseY=e.clientY;}
      addEventListener('mousemove', MouseEv);
      function TouchEv(e){
         if(e.touches && e.touches[0]){
            var t=e.touches[0];
            mouseX=t.clientX; mouseY=t.clientY;
         }
      };
      addEventListener('touchstart', TouchEv, {passive:true});
      addEventListener('touchmove', TouchEv, {passive:true});
      var mouseX=null, mouseY=null;
      var inn=false;
      var msPassed=0;
      var PI=Math.PI;
      var tau=PI*2;
      var snubbedFrames = 0;
      var lastBlink=0;
      var blinkIndex=0;
      
      var rightLidScale;
      var rightLidFunct;
      var rightLidSRad;
      var rightLidERad;
      
      var leftLidScale;
      var leftLidFunct;
      var leftLidSRad;
      var leftLidERad;
      
      var eyeYScale=0.5;

      var cRotX=0, cRotY=0;
      var rPupilX=0, rPupilY=0, lPupilX=0, lPupilY=0;
      var lEyeX, lEyeY, rEyeX, rEyeY;

      var goingOut;
      var rEyeCheckX, rEyeCheckY, lEyeCheckX, lEyeCheckY;
      var rLongEyeCheckX, rLongEyeCheckY, lLongEyeCheckX, lLongEyeCheckY;

      function GetBlink(ind){
         switch(ind){
            case 0:
               return {scale:0.5, funct:"arc", sRad:tau, eRad:PI};
               rightLidScale=leftLidScale=0.5;
               rightLidFunct=leftLidFunct="arc";
               rightLidSRad=leftLidSRad=tau;
               rightLidERad=leftLidERad=PI;

               
               break;
            case 1:
            case 7:
               return {scale:0.25, funct:"arc", sRad:tau, eRad:PI};
               rightLidScale=leftLidScale=0.25;
               rightLidFunct=leftLidFunct="arc";
               rightLidSRad=leftLidSRad=tau;
               rightLidERad=leftLidERad=PI;
               break;
            case 2:
            case 6:
               return {scale:0.1, funct:"arc", sRad:tau, eRad:PI};
               rightLidScale=leftLidScale=0.1;
               rightLidFunct=leftLidFunct="arc";
               rightLidSRad=leftLidSRad=tau;
               rightLidERad=leftLidERad=PI;
               break;
            case 3:
            case 5:
               return {scale:0.25, funct:"arc", sRad:PI, eRad:0};
               rightLidScale=leftLidScale=0.25;
               rightLidFunct=leftLidFunct="arc";
               rightLidSRad=leftLidSRad=PI;
               rightLidERad=leftLidERad=0;
               break;
            case 4:
               return {scale:1, funct:"arc", sRad:PI, eRad:0};
               rightLidScale=leftLidScale=1;
               rightLidFunct=leftLidFunct="arc";
               rightLidSRad=leftLidSRad=PI;
               rightLidERad=leftLidERad=0;
               break;

         }
      }

      function CalcEyes(){
         lEyeX=mainCanv.width*0.25;
         rEyeX=mainCanv.width*0.75;

         lEyeY=rEyeY=mainCanv.height*0.25;
         if(mouseX !== null){
            
            lPupilX=Math.sin(Math.atan2((mouseX-lEyeX),(mouseY-lEyeY)))*10;
            lPupilY=Math.cos(Math.atan2((mouseX-lEyeX),(mouseY-lEyeY)))*5;
            rPupilX=Math.sin(Math.atan2((mouseX-rEyeX),(mouseY-rEyeY)))*10;
            rPupilY=Math.cos(Math.atan2((mouseX-rEyeX),(mouseY-rEyeY)))*5;
            
            lEyeCheckX=Math.sin(Math.atan2((mouseX-lEyeX),(mouseY-lEyeY)))*50;
            lEyeCheckY=Math.cos(Math.atan2((mouseX-lEyeX),(mouseY-lEyeY)))*25;
            rEyeCheckX=Math.sin(Math.atan2((mouseX-rEyeX),(mouseY-rEyeY)))*50;
            rEyeCheckY=Math.cos(Math.atan2((mouseX-rEyeX),(mouseY-rEyeY)))*25;

            lLongEyeCheckX=Math.sin(Math.atan2((mouseX-lEyeX),(mouseY-lEyeY)))*50*1.1;
            lLongEyeCheckY=Math.cos(Math.atan2((mouseX-lEyeX),(mouseY-lEyeY)))*25*1.1;
            rLongEyeCheckX=Math.sin(Math.atan2((mouseX-rEyeX),(mouseY-rEyeY)))*50*1.1;
            rLongEyeCheckY=Math.cos(Math.atan2((mouseX-rEyeX),(mouseY-rEyeY)))*25*1.1;
            
            var lEyeShortCheck=Math.sqrt(lEyeCheckX**2+lEyeCheckY**2);
            var lEyeLongCheck=Math.sqrt(lLongEyeCheckX**2+lLongEyeCheckY**2);
            var lEyeActCheck=Math.sqrt((mouseX-lEyeX)**2+(mouseY-lEyeY)**2);

            var rEyeShortCheck=Math.sqrt(rEyeCheckX**2+rEyeCheckY**2);
            var rEyeLongCheck=Math.sqrt(rLongEyeCheckX**2+rLongEyeCheckY**2);
            var rEyeActCheck=Math.sqrt((mouseX-rEyeX)**2+(mouseY-rEyeY)**2);

            var canvTransString=[];
            var by=(goingOut? 0.2 : 0.1);

            if(lEyeY > mouseY){
               cRotX=(Lerp(cRotX, parseInt((mouseY-lEyeY)*30/lEyeY),by) || 0).toFixed(2);
               canvTransString.push("rotateX("+cRotX+"deg)");
            }else if(lEyeY <= mouseY){
               cRotX=(Lerp(cRotX, parseInt((mouseY-lEyeY)*45/(mainCanv.height*0.75)),by) || 0).toFixed(2); 
               canvTransString.push("rotateX("+(cRotX)+"deg)");
            }
            cRotX=parseFloat(cRotX);
            var half=mainCanv.width/2;

               cRotY=(Lerp(cRotY,parseInt((half-mouseX)*45/(half)),by) || 0).toFixed(2);
               canvTransString.push("rotateY("+(cRotY)+"deg)");
            
            cRotY=parseFloat(cRotY);
            canvWrap.style.transform=canvTransString.join(' ');
         }else{
            lPupilX=lPupilY=rPupilX=lPupilY=0;
         }         
 

         if(blinkIndex || (lastBlink > 333 && !Math.floor(Math.random()*((500-lastBlink/10)))) || lastBlink >= 5000){
            blinkIndex+=1;
            blinkIndex%=8;
            if(!blinkIndex){lastBlink=0;}
         }
         var rBlink=lBlink=blinkIndex;
         var lBlinkOverride=0, rBlinkOverride=0;
         

         var lBlink=GetBlink(lBlink);
         leftLidScale=lBlink.scale;
         leftLidFunct=lBlink.funct;
         leftLidSRad=lBlink.sRad;
         leftLidERad=lBlink.eRad;
         var rBlink=GetBlink(rBlink);
         rightLidScale=rBlink.scale;
         rightLidFunct=rBlink.funct;
         rightLidSRad=rBlink.sRad;
         rightLidERad=rBlink.eRad;

         if(lEyeActCheck <= lEyeShortCheck){
            leftLidScale=1;leftLidSRad=PI;leftLidERad=0;
         }else if(lEyeActCheck <= lEyeLongCheck){
            var dif=lEyeLongCheck-lEyeShortCheck;
            var mid=lEyeShortCheck+dif/2;
            var tempLidScale=-0.5+(1.5*(lEyeActCheck-lEyeShortCheck)/dif);
            var aComp=tempLidScale;
            tempLidScale=tempLidScale || 0.1;
            var tempLidERad=0, tempLidSRad=PI;
            if(tempLidScale < 0){
               tempLidScale*=-1;
               tempLidERad=PI; tempLidSRad=tau;
            }
            
            
            var bComp=(leftLidERad ? leftLidScale *-1 : leftLidScale);

            if(bComp < aComp){
               leftLidScale=tempLidScale; leftLidERad=tempLidERad; leftLidSRad=tempLidSRad;
            }
         }

         if(rEyeActCheck <= rEyeShortCheck){
            rightLidScale=1;rightLidSRad=PI;rightLidERad=0;
         }else if(rEyeActCheck <= rEyeLongCheck){
            var dif=rEyeLongCheck-rEyeShortCheck;
            var mid=rEyeShortCheck+dif/2;
            var tempLidScale=-0.5+(1.5*(rEyeActCheck-rEyeShortCheck)/dif);
            var aComp=tempLidScale;
            tempLidScale=tempLidScale || 0.1;
            var tempLidERad=0, tempLidSRad=PI;
            if(tempLidScale < 0){
               tempLidScale*=-1;
               tempLidERad=PI; tempLidSRad=tau;
            }
            
            
            var bComp=(rightLidERad ? rightLidScale *-1 : rightLidScale);

            if(bComp < aComp){
               rightLidScale=tempLidScale; rightLidERad=tempLidERad; rightLidSRad=tempLidSRad;
            }
         }
         
      }
      function CalcPassed(f){
         msPassed+=f*1000/60;

         lastBlink+=f*1000/60;
      }
      
      var  inDir=[], 
           inScale=[],
           inMouth=[], inMouth2=[];
      for(var i=0; i<19; i++)
      {
         inScale.push(0.05*(i+1));
         inDir.push(false);
         inMouth.push(i/36);
         inMouth2.push((i+18)/36);
      }
      inMouth=inMouth.concat(inMouth2);
      inScale=_ob.CLONE(inScale).reverse().concat(inScale);
      inDir=inDir.map(function(d){return !d;}).concat(inDir).reverse();

      var outMouth=_ob.CLONE(inMouth).reverse();
      var outScale=_ob.CLONE(inScale).reverse();
      var outDir=_ob.CLONE(inDir).reverse();

      var skipInd=0;
      var scaleCat, dirCat, mouthCat;
     
      function In(self, f, curView){
         if(!canvWrap.style.borderRadius){canvWrap.style.borderRadius="47%";}
         CalcEyes();
         CalcPassed(f);
         snubbedFrames++;
         
         if(snubbedFrames < 30){return self;}
         
            scaleCat=inScale.pop(), dirCat=inDir.pop();
         mouthCat=inMouth.shift();
 
         mainCtx.save();
         mainCtx.beginPath();
         mainCtx.scale(1,eyeYScale);
         mainCtx.moveTo(lEyeX-50, lEyeY*(1/eyeYScale));
         mainCtx.arc(lEyeX, lEyeY*(1/eyeYScale), 50, 0, PI);
         mainCtx.scale(1, scaleCat);
         mainCtx.arc(lEyeX, lEyeY*(1/eyeYScale)*(1/scaleCat), 50,  PI, 0, dirCat);
         mainCtx.scale(1, 1/scaleCat);
         mainCtx.moveTo(rEyeX-50, rEyeY*(1/eyeYScale));
         mainCtx.arc(rEyeX, rEyeY*(1/eyeYScale), 50, 0, PI);
         mainCtx.scale(1, scaleCat);
         mainCtx.arc(rEyeX, rEyeY*(1/eyeYScale)*(1/scaleCat), 50, PI, 0, dirCat);
         mainCtx.fillStyle="white";
         mainCtx.fill();

         
         
         
         mainCtx.restore();
         mainCtx.save();
         mainCtx.globalCompositeOperation="source-atop";
         DrawEyes();
         mainCtx.restore();
         mainCtx.save();
         
         DrawMouth();
         mainCtx.fillStyle="white";
         var h=mainCanv.height, w=mainCanv.width;
         mainCtx.clearRect(0, h*0.7, w*0.52*(1-mouthCat), h*0.25);
         mainCtx.clearRect(w*0.24+w*mouthCat, h*0.7, w, h*0.25);

         
         mainCtx.restore();
         return (inScale.length ? self : Loop);
      }
      function DrawMouth(){
         
         mainCtx.beginPath();
         mainCtx.save();
         mainCtx.moveTo(lEyeX, mainCanv.height*0.75);
         mainCtx.quadraticCurveTo(mainCanv.width/2, mainCanv.height*0.82, rEyeX, mainCanv.height*0.75);


        
         mainCtx.strokeStyle='black';
         mainCtx.stroke();
         mainCtx.restore();
      }
      function DrawEyes(){
           mainCtx.save();
         mainCtx.scale(1,eyeYScale);
         mainCtx.beginPath();
         mainCtx.arc(lEyeX, lEyeY*(1/eyeYScale), 50, 0, tau);
         mainCtx.moveTo(rEyeX+50, rEyeY*(1/eyeYScale));
         mainCtx.arc(rEyeX, rEyeY*(1/eyeYScale), 50, 0, tau);
         
         mainCtx.fillStyle="white";
         mainCtx.strokeStyle="black";
         
         mainCtx.fill();
         mainCtx.stroke();
         mainCtx.restore();


         mainCtx.save();
         mainCtx.beginPath();
         mainCtx.moveTo(lEyeX+lPupilX-10, lEyeY+lPupilY);
         mainCtx.arc(lEyeX+lPupilX, lEyeY+lPupilY, 10, 0, tau);
         mainCtx.moveTo(rEyeX+rPupilX-10, rEyeY+rPupilY);
         mainCtx.arc(rEyeX+rPupilX, rEyeY+rPupilY, 10, 0, tau);

         mainCtx.fillStyle='skyBlue';
         mainCtx.fill();

         mainCtx.beginPath();
         mainCtx.moveTo(lEyeX+lPupilX-5, lEyeY+lPupilY);
         mainCtx.arc(lEyeX+lPupilX, lEyeY+lPupilY, 5, 0, tau);
         mainCtx.moveTo(rEyeX+rPupilX-5, rEyeY+rPupilY);
         mainCtx.arc(rEyeX+rPupilX, rEyeY+rPupilY, 5, 0, tau);
         mainCtx.fillStyle="black";
         mainCtx.fill();
         mainCtx.restore();

         mainCtx.save();
         mainCtx.beginPath();
         mainCtx.scale(1,eyeYScale);
         mainCtx.arc(lEyeX,lEyeY*(1/eyeYScale), 50, PI, tau);
         if(leftLidFunct === "arc"){
           mainCtx.scale(1,leftLidScale);
           mainCtx.moveTo(lEyeX+50, lEyeY*(1/leftLidScale)*(1/eyeYScale));
           mainCtx.arc(lEyeX, lEyeY*(1/leftLidScale)*(1/eyeYScale),50, leftLidSRad, leftLidERad, true);
           mainCtx.scale(1, 1/leftLidScale);
         }else{
            mainCtx.lineTo(lEyeX-50, lEyeY*(1/eyeYScale));
         }
         mainCtx.moveTo(rEyeX+50, rEyeY*(1/eyeYScale));
         mainCtx.arc(rEyeX, rEyeY*(1/eyeYScale), 50, PI, tau);
         if(rightLidFunct === "arc"){
           mainCtx.scale(1,rightLidScale);
           mainCtx.moveTo(rEyeX+50, rEyeY*(1/rightLidScale)*(1/eyeYScale));
           mainCtx.arc(rEyeX, rEyeY*(1/rightLidScale)*(1/eyeYScale),50, rightLidSRad, rightLidERad, true);
           mainCtx.scale(1, 1/rightLidScale);
         }else{
            mainCtx.lineTo(rEyeX-50, rEyeY*(1/eyeYScale));
         }
         mainCtx.fillStyle="yellow";
         mainCtx.fill();
         mainCtx.restore();
      }

      function Out(self, f, curView){
         
         mouseX=mainCanv.width/2; mouseY=mainCanv.height/4;
         goingOut=true;
         CalcPassed(f);
         CalcEyes();
         
            scaleCat=outScale.pop(), dirCat=outDir.pop();
         mouthCat=outMouth.shift();
 
         mainCtx.save();
         mainCtx.beginPath();
         mainCtx.scale(1,eyeYScale);
         mainCtx.moveTo(lEyeX-50, lEyeY*(1/eyeYScale));
         mainCtx.arc(lEyeX, lEyeY*(1/eyeYScale), 50, 0, PI);
         mainCtx.scale(1, scaleCat);
         mainCtx.arc(lEyeX, lEyeY*(1/eyeYScale)*(1/scaleCat), 50,  PI, 0, dirCat);
         mainCtx.scale(1, 1/scaleCat);
         mainCtx.moveTo(rEyeX-50, rEyeY*(1/eyeYScale));
         mainCtx.arc(rEyeX, rEyeY*(1/eyeYScale), 50, 0, PI);
         mainCtx.scale(1, scaleCat);
         mainCtx.arc(rEyeX, rEyeY*(1/eyeYScale)*(1/scaleCat), 50, PI, 0, dirCat);
         mainCtx.fillStyle="white";
         mainCtx.fill();

         
         
         
         mainCtx.restore();
         mainCtx.save();
         mainCtx.globalCompositeOperation="source-atop";
         DrawEyes();
         mainCtx.restore();
         mainCtx.save();
         
         DrawMouth();
         var h=mainCanv.height, w=mainCanv.width;
         mainCtx.clearRect(0, h*0.7, w*0.52*(1-mouthCat), h*0.25);
         mainCtx.clearRect(w*0.24+w*mouthCat, h*0.7, w, h*0.25);

         
         mainCtx.restore();
         if(outScale.length){return self;}
         canvWrap.style.removeProperty('transform');
         canvWrap.style.removeProperty('border-radius');
         removeEventListener('mousemove', MouseEv);
         removeEventListener('touchstart', TouchEv);
         removeEventListener('touchmove', TouchEv);
         return false;
      }

      return In;
      function Loop(self, f, curView){
         if(!canvWrap.style.borderRadius){canvWrap.style.borderRadius="47%";}
         CalcPassed(f);

         CalcEyes();

         
         DrawEyes();

         DrawMouth();

         
         if(curView !== cv){return Out;}
         return self;
         
      }
      
   };
/*cloudsAnimationFamily*/
AniFamilies.Clouds=function(cv){
      var numCores=0;
      var coreLimit=300;
      SetGraphics({page:{
        name:'Sky',
        description:'The clouds and the sun',
        interactivity:[
           "Drag your cursor or your finger across the screen, and part the clouds.",
           "Stick around and see the sun trace across the sky."
        ]
      }});
      function Lerp(a,b,by){return a+(b-a)*by;}
    function DetectDir(a,s,e){if(s > e){return Math.floor(a);}return Math.ceil(a);}
    
    var mouseX=null, mouseY=null;
    function MouseFunct(e){
        mouseX=e.clientX; mouseY=e.clientY;
    }
    function TouchFunct(e){
       if(e.touches && e.touches[0]){
          var t=e.touches[0];
          mouseX=t.clientX; mouseY=t.clientY;
       }
    }
    addEventListener('mousemove', MouseFunct);
    addEventListener('touchstart', TouchFunct, {passive:true});
    addEventListener('touchmove', TouchFunct, {passive:true});
    

    
    var snubbedFrames=0;
    var PI=Math.PI;
    var tau=PI*2;

    var levels=[[],[],[]];
    var levelColors=["lightGrey", "white", "white"];
    var clouds=[];

    var x=0.5,y=0.5;
    
    var h,w,hw,hh,cRad,tlTh, trTh, blTh, brTh;
    var rendS, rendE;
 
    var inAlpha=0.01;
    var opaTarget=0.3;

    
    var sunRad=25;
    var sunSpeed=0.001;
    var sunPAng=PI;
    var sunr1=255, sunr2=255;
    var sung1=240, sung2=223;
    var sunb1=20, sunb2=0;
    var sunr=sunr1, sung=sung1, sunb=sunb1;

    var elapsedFrames=0;
    

    function FillClouds(first){
      h=mainCanv.height; hh=h/2;
       w=mainCanv.width; hw=w/2;
       
       cRad=Math.sqrt((w/2)**2+(h/2)**2);
       tlTh=Math.atan2((-hw),(-hh));
       trTh=Math.atan2((hw),(-hh));
       blTh=Math.atan2((hw),(-hh));
       brTh=Math.atan2((hw),(hh));
       
       if(x>0){
          if(y>0){
             rendS=blTh;
             rendE=trTh;
          }else if(y<0){
             rendS=brTh;
             rendE=tlTh;
          }else{
            rensS=blTh; rendE=tlTh;
          }
       }else if(x<0){
          if(y>0){
             rendS=tlTh;
             rendE=brTh;
          }else if(y<0){
             rendS=trTh;
             rendE=blTh;
          }else{
            rensS=trTh; rendE=brTh;
          }
       }else{
          if(y>0){
             rendS=tlTh;
             rendE=trTh;
          }else if(y<0){
             rendS=brTh;
             rendE=blTh;
          }else{
            rensS=blTh; rendE=blTh;
          }
       }

       if(rendE <= rendS){rendE+=tau;}
      var numMade=0;
      while(clouds.length <12 && numMade<5)
      {
         numMade++;
         clouds.push(new Cloud(first));
      }
      if(mouseX !== null){
        clouds.forEach(function(c){c.CHECK(mouseX, mouseY);});
      }
      mouseX=null, mouseY=null;
    }
    function In(self,f,curView){
       snubbedFrames++;
       if(snubbedFrames < 30){
          return self;
       }
       FillClouds(true);
       inAlpha+=0.02;
       Draw(f,Math.min(inAlpha, opaTarget));
       if(inAlpha < opaTarget){
          return In;
       }
       return Loop;
    }
    function Loop(self, f, curView){
       Draw(f);
       if(curView !== cv){
          return Out;
       }
       return self;
    }
    function Out(self,f,curView){
        inAlpha-=0.2;
        Draw(f, Math.max(inAlpha, 0));
        if(inAlpha <= 0){
           removeEventListener('mousemove', MouseFunct);
           removeEventListener('touchstart', TouchFunct);
           removeEventListener('touchmove', TouchFunct);
           return false;
        }
        return Out;
    }

    
    var sunColorDir=false;
    function Draw(f,alphaOverride){
       elapsedFrames+=f;
       levels=[[],[],[]];
       
       clouds=clouds.filter(function(c){return c.active || c.cores.length;});
       FillClouds();

       sunPAng+=sunSpeed*f;
       sunPAng%=tau;
       mainCtx.beginPath();
       mainCtx.save();
       if(sunColorDir){
          sunr=Lerp(sunr, sunr2, 0.05*f);
          sung=Lerp(sung, sung2, 0.05*f);
          sunb=Lerp(sunb, sunb2, 0.05*f);
          if(Math.abs(sunr -sunr2) < 0.5 && Math.abs(sung-sung2) <0.5 && Math.abs(sunb- sunb2) < 0.5){sunColorDir=!sunColorDir;}
       }else{
          sunr=Lerp(sunr, sunr1, 0.05*f);
          sung=Lerp(sung, sung1, 0.05*f);
          sunb=Lerp(sunb, sunb1, 0.05*f);
          if(Math.abs(sunr -sunr1) < 0.5 && Math.abs(sung-sung1) <0.5 && Math.abs(sunb- sunb1) < 0.5){sunColorDir=!sunColorDir;}
       }
       
     

       mainCtx.arc((hw/2-Math.sin(sunPAng)*(Math.min(w,h))), h-Math.cos(sunPAng)*(Math.min(w,h)), sunRad, 0, tau);
       mainCtx.fillStyle='rgb('+sunr+','+sung+','+sunb+')';
       mainCtx.fill();
       mainCtx.restore();

       
       clouds.forEach(function(c){c.COLLECT(f,x,y);});
       levels.forEach(function(l, i){
         mainCtx.save();
         mainCtx.beginPath();
         mainCtx.fillStyle=levelColors[i];
         l.forEach(function(d){d.DRAW();});
         mainCtx.globalAlpha=alphaOverride || opaTarget;
         mainCtx.fill();
         mainCtx.restore();
       });
    };

    function Cloud(first){
       var size=Math.sqrt((mainCanv.width/2)**2+(mainCanv.height/2)**2)*1.3;
       this.active=true;
       this.speed=0.1+Math.random();
       
       
       
       
       var randTh=Math.random()*(rendE-rendS)+rendS;
       this.x=hw-Math.cos(randTh)*cRad*1.5;
       this.y=hh-Math.sin(randTh)*cRad*1.5;
       
       if(first){
          this.x=Math.random()*mainCanv.width;
          this.y=Math.random()*mainCanv.height;
       }
       this.cores=[];
       var mx=Math.floor(Math.random()*5)+1;
       for(var i=0; i<mx && numCores < coreLimit; i++)
       {
          this.cores.push(new Node(
             this, /* par */
             10, /* max cores*/
             50,/* maxdist*/
             30,/* max rad,*/
             0 /* level*/
          ));
       }
       
    };
    Cloud.prototype.COLLECT=function(f,x,y){
       x*=this.speed; y*=this.speed;
       this.x+=x*f; this.y+=y*f;
       if(
          (x >= 0 && this.x > mainCanv.width) ||
          (x < 0 && this.x < 0) ||
          (y >= 0 && this.y > mainCanv.height) ||
          (y < 0 && this.y < 0)
       ){
          this.active=false;
       }
       this.cores=this.cores.filter(function(c){return c.active || c.cores.length;});
       this.cores.forEach(function(c){c.COLLECT(f,x,y);});
    };
    Cloud.prototype.CHECK=function(x,y){this.cores.forEach(function(c){c.CHECK(x,y);});};

    function Node(par,maxCores, maxDist,maxRad, level,sx,sy){
       numCores++;
       this.level=level;
       this.par=par;
       var ang=Math.random()*tau;
       var dist=Math.random()*maxDist;
       this.rad=Math.random()*maxRad;
       this.active=true;
       if(typeof sx === 'undefined'){
          this.x=par.x+Math.cos(ang)*dist;
          this.y=par.y+Math.sin(ang)*dist;
       }else{this.x=sx; this.y=sy; }
       this.cores=[];

       var mx=Math.floor(Math.random()*maxCores)+1
       for(var i=0; i<mx && level < levels.length-1 && numCores < coreLimit; i++)
       {
          this.cores.push(new Node(
             this,
             maxCores/2,
             maxDist+2,
             maxRad+8,
             level+1
          ));
       }
    };
    Node.prototype.CHECK=function(x,y){
       var xch=this.x-x, ych=this.y-y;
       this.cores.forEach(function(c){c.CHECK(x,y);});
       if(Math.sqrt((xch)**2+(ych)**2) < this.rad){
          if(this.rad<=5){this.rad=0; return;}
          var sqt2=this.rad*1.414;
          if(xch < 0){
             if(ych<0){
                this.par.cores.push(
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x+sqt2, this.y+sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x-sqt2, this.y+sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x+sqt2, this.y-sqt2)
                );
             }else{
                this.par.cores.push(
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x+sqt2, this.y-sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x-sqt2, this.y-sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x+sqt2, this.y+sqt2)
                );
             }
          }else{
             if(ych<0){
                this.par.cores.push(
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x+sqt2, this.y+sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x-sqt2, this.y+sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x-sqt2, this.y-sqt2)
                );
             }else{
                this.par.cores.push(
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x-sqt2, this.y-sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x-sqt2, this.y+sqt2),
                   new Node(this.par,this.maxCores, this.maxDist*0.8,this.maxRad*0.8, this.level,this.x+sqt2, this.y-sqt2)
                );
             }
             
          }
          this.rad=0;
       }
    };
    Node.prototype.COLLECT=function(f,x,y){
       
       levels[this.level].push(this);
       this.x+=x*f; this.y+=y*f;
       if(
          (x >= 0 && this.x-this.rad > mainCanv.width) ||
          (x < 0 && this.x+this.rad < 0) ||
          (y >= 0 && this.y-this.rad > mainCanv.height) ||
          (y < 0 && this.y+this.rad < 0)
       ){
          if(this.active){numCores--;}
          this.active=false;
       }

       this.cores=this.cores.filter(function(c){return c.active || c.cores.length;});
       this.cores.forEach(function(c){c.COLLECT(f,x,y);});
    };
    Node.prototype.DRAW=function(){
       mainCtx.moveTo(this.x+this.rad, this.y);
       mainCtx.arc(this.x, this.y, this.rad, 0, tau);
    };
    return In;
    
};
/*BackgroundColors*/
globalBackgroundColors={
   Contact:'#0B1026'
};
/*spaceAnimation*/
AniFamilies.Space=function(cv){

      SetGraphics({page:{
        name:'Space',
        description:'Where no one has gone before.',
        interactivity:[
           "The ship follows your finger or your cursor across the screen."
        ]
      }});
   var snubbedFrames=0;
   var mouseX=null, mouseY=null;
    function OnSize(e){
       
    }
    function MouseFunct(e){
        mouseX=e.clientX; mouseY=e.clientY;
    }
    function TouchFunct(e){
       if(e.touches && e.touches[0]){
          var t=e.touches[0];
          mouseX=t.clientX; mouseY=t.clientY;
       }
    }
    addEventListener('mousemove', MouseFunct);
    addEventListener('touchstart', TouchFunct, {passive:true});
    addEventListener('touchmove', TouchFunct, {passive:true});
    addEventListener('resize', OnSize);
    

    var x=0, y=0;
    var shipSpeed=0;
    var shipMaxSpeed=0.004;
    var shipScale=80;

    var shipHeight=40;
    var shipWidth=16;
    var hsh=shipHeight/2;
    var hsw=shipWidth/2;
    var lowestShip=0;
    

    var stars=[];
    var stars2=[];
    var stars3=[];
    for(var i=0; i<50; i++)
    {stars.push({x:Math.random()*2-0.5, y:Math.random()*2-0.5});}
    for(var i=0; i<50; i++)
    {stars2.push({x:Math.random()*2-0.5, y:Math.random()*2-0.5});}
    for(var i=0; i<50; i++)
    {stars3.push({x:Math.random()*2-0.5, y:Math.random()*2-0.5});}
    
    var shipAngle=0;
    var targetShipAngle=0;
    var h,w,hh,hw;
    var headedOut=false;
      
    var shipBottom, shipBottomLeft, shipBottomRight;

    
    function Fire(fillStyle){
       var shipWidth=shipBottomRight-shipBottomLeft-2;
       var hsw=shipWidth/2;
       mainCtx.fillStyle=fillStyle;
       var rand=Math.random()*(shipWidth-2)-(hsw-1);
       mainCtx.beginPath();
       mainCtx.moveTo(rand-1, shipBottom);
       mainCtx.lineTo(rand, shipBottom*1.6);
       mainCtx.lineTo(rand+1, shipBottom);
       mainCtx.closePath();
       mainCtx.fill();
    }
    function DrawShipOld(){
       if(mouseX !== null){
          targetShipAngle=-Math.atan2((mouseX-hw),(mouseY-hh))+PI;
          shipAngle=Lerp(shipAngle, targetShipAngle, 0.01);
       }
       x=Lerp(x, -Math.sin(shipAngle)*shipMaxSpeed, 0.01);
       y=Lerp(y, Math.cos(shipAngle)*shipMaxSpeed, 0.01);
       mainCtx.save();
       mainCtx.beginPath();
       mainCtx.translate(hw, hh);
       mainCtx.rotate(shipAngle);
       mainCtx.moveTo(0, -hsh);
       mainCtx.lineTo(-hsw, hsh);
       mainCtx.lineTo(hsw, hsh);
       mainCtx.fillStyle="gray";
       mainCtx.strokeStyle="gold";
       mainCtx.stroke();
       mainCtx.fill();
       Fire("orange");
       Fire("yellow");
       Fire("gold");
       mainCtx.restore();
    }
   function DrawShip(){
       if(mouseX !== null){
          targetShipAngle=-Math.atan2((mouseX-hw),(mouseY-hh))+PI;   
          targetShipAngle%=tau;
         
          
          if(Math.abs(shipAngle-targetShipAngle) < PI){
             shipAngle=Lerp(shipAngle, targetShipAngle, 0.1);
          }else{
             if(shipAngle < PI){
                shipAngle=Lerp(shipAngle, targetShipAngle-tau, 0.1);
             }else{
                
                shipAngle=Lerp(shipAngle, targetShipAngle+tau, 0.1);
             }
          }
          if(shipAngle < 0){shipAngle+=tau;}
          shipAngle%=tau;
       }
       x=Lerp(x, -Math.sin(shipAngle)*shipMaxSpeed, 0.01);
       y=Lerp(y, Math.cos(shipAngle)*shipMaxSpeed, 0.01);
        var drawX=0, drawY=0; 
        mainCtx.save();
        mainCtx.translate(hw, hh);
        mainCtx.rotate(shipAngle);
	mainCtx.beginPath();
	mainCtx.moveTo(drawX+(0*shipScale),drawY+(0*shipScale));
	mainCtx.moveTo(drawX+(0*shipScale),drawY+(-0.5761421319796954*shipScale));
	mainCtx.quadraticCurveTo(drawX+(-0.2639593908629442*shipScale),drawY+(-0.1598984771573604*shipScale),drawX+(-0.16243654822335024*shipScale),drawY+(0.2817258883248731*shipScale));
	mainCtx.lineTo(drawX+(0.16243654822335024*shipScale),drawY+(0.2817258883248731*shipScale));
	mainCtx.quadraticCurveTo(drawX+(0.2639593908629442*shipScale),drawY+(-0.1598984771573604*shipScale),drawX+(0*shipScale),drawY+(-0.5761421319796954*shipScale));
	mainCtx.save();
	mainCtx.fillStyle="#FF5733";
	mainCtx.fill();
	mainCtx.restore();
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	mainCtx.beginPath();
	mainCtx.moveTo(drawX+(-0.10152284263959391*shipScale),drawY+(0.2817258883248731*shipScale));
	mainCtx.lineTo(drawX+(-0.16243654822335024*shipScale),drawY+(0.42385786802030456*shipScale));
        shipBottom=drawY+(0.42385786802030456*shipScale);
        shipBottomLeft=drawX+(-0.16243654822335024*shipScale);
        shipBottomRight=drawX+(0.16243654822335024*shipScale);
	mainCtx.lineTo(drawX+(0.16243654822335024*shipScale),drawY+(0.42385786802030456*shipScale));
	mainCtx.lineTo(drawX+(0.10152284263959391*shipScale),drawY+(0.2817258883248731*shipScale));
	mainCtx.closePath();
	mainCtx.save();
	mainCtx.fillStyle="gray";
	mainCtx.fill();
	mainCtx.restore();
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	mainCtx.beginPath();
	mainCtx.moveTo(drawX+(0.10152284263959391*shipScale),drawY+(-0.07360406091370558*shipScale));
	mainCtx.arc(drawX+(0*shipScale),drawY+(-0.07360406091370558*shipScale), 0.10152284263959391*shipScale, 6.283, 0, true);
	mainCtx.save();
	mainCtx.fillStyle="yellow";
	mainCtx.fill();
	mainCtx.restore();
	mainCtx.lineTo(drawX+(-0.10152284263959391*shipScale),drawY+(-0.07360406091370558*shipScale));
	mainCtx.moveTo(drawX+(0*shipScale),drawY+(-0.1751269035532995*shipScale));
	mainCtx.lineTo(drawX+(0*shipScale),drawY+(0.027918781725888325*shipScale));
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
        Fire("orange");
        Fire("yellow");
        Fire("gold");
 
        mainCtx.restore();
}
    function CalcFrame(){
       h=mainCanv.height; hh=h/2;
       w=mainCanv.width; hw=w/2;
    }
    function CrunchStar(s, f, speedAlt){
       s.x=Lerp(s.x,0.5,0.1);
       s.y=Lerp(s.y,0.5, 0.1);
       if(Math.abs(s.x-0.5)< 0.01 && Math.abs(s.y-0.5) < 0.01){
          s.dead=true;
       }
    }
    function ProgressStar(s, f, speedAlt){
       s.x+=x*speedAlt*f; s.y+=y*speedAlt*f;
          var sx=s.x, sy=s.y;
          if(x>0 && sx > 1.5){
             s.x=sx=-0.5;
             s.y=sy=Math.random()*2-0.5;
          }else if(x<0 && sx<-0.5){
             s.x=sx=1.5;
             s.y=sy=Math.random()*2-0.5;
             
          }
          if(y>0 && sy>1.5){
             s.y=sy=-0.5;
             s.x=sx=Math.random()*2-0.5;
          }else if(y<0 && sy<-0.5){
             s.y=sy=1.5;
             s.x=sx=Math.random()*2-0.5;
          }
    }
    function StarDraw(s, f,speedAlt){
       speedAlt=speedAlt || 1;
         if(headedOut){
            CrunchStar(s,f,speedAlt);
         }else{
            ProgressStar(s,f,speedAlt);
         }
       
       
          mainCtx.moveTo(s.x*w+2, s.y*h);
          mainCtx.arc(s.x*w, s.y*h, 2, 0, tau);
    }
    function DrawStars(f){
       mainCtx.save();
       mainCtx.beginPath();
       mainCtx.fillStyle="rgba(255,255,255,0.3)";
       stars3.forEach(function(s){StarDraw(s,f,0.2);});
       mainCtx.fill();
       mainCtx.beginPath();
       mainCtx.fillStyle="rgba(255,255,255,0.4)";
       stars2.forEach(function(s){StarDraw(s,f,0.5);});   
       mainCtx.fill();     
       mainCtx.beginPath();
       mainCtx.fillStyle="white";
       stars.forEach(function(s){StarDraw(s,f);});
       mainCtx.fill();
       mainCtx.restore();
    }

   var inRad=0;
      
   function In(self, f, curView){
      snubbedFrames++;
      if(snubbedFrames<31){
         return self;
      }
      mainCtx.save();
      mainCtx.fillStyle=globalBackgroundColors[cv];
      mainCtx.beginPath();
      mainCtx.arc(mainCanv.width/2, mainCanv.height/2,inRad, 0, tau);
      inRad+=10*f;
      mainCtx.fill();
      mainCtx.strokeStyle="black";
      mainCtx.stroke();
      mainCtx.globalCompositeOperation="source-atop";
      CalcFrame();
      DrawStars(f);
      DrawShip();
      mainCtx.restore();
      if(cv !== curView){
         headedOut=true;
         return Out;
      }
      if(inRad >= Math.sqrt((mainCanv.width/2)**2+(mainCanv.height/2)**2)){
         return Loop;
      }
      return self;
   }
   function Loop(self, f,curView){
      CalcFrame();
      DrawStars(f);
      DrawShip();
      
      if(cv !== curView){
         headedOut=true;
         return Out;
      }
      return self;
   }
   function Out(self,f,curView){
      stars3=stars3.filter(function(s){return !s.dead;});
      stars2=stars2.filter(function(s){return !s.dead;});
      stars=stars.filter(function(s){return !s.dead;});
      shipScale=Lerp(shipScale, 1, 0.05);
      CalcFrame();
      DrawStars(f);
      DrawShip(0,0,20);
      if(!(stars.length || stars2.length || stars3.length)){
        removeEventListener('resize', OnSize);
        removeEventListener('mousemove', MouseFunct);
        removeEventListener('touchstart', TouchFunct);
        removeEventListener('touchmove', TouchFunct);
        return false;
      }
      return self;
   }

  
   return In;
};
/*animationLib*/
function Lerp(a,b,by){return a+(b-a)*by;};
PI=Math.PI;
tau=PI*2;
/*fishAnimation*/
AniFamilies.Fish=function(cv){

      SetGraphics({page:{
        name:'Fishes',
        description:'Down in the deep.',
        interactivity:[
           "Click or touch a fish, and watch it scurry away."
        ]
      }});
   var fish=[];
   
   var mouseX=null, mouseY=null;
   
   function MouseEv(e){
      mouseX=e.clientX; mouseY=e.clientY;
   }
   function TouchEv(e){
      if(e.touches && e.touches[0]){
         mouseX=e.touches[0].clientX; mouseY=e.touches[0].clientY;
      }
   }
   addEventListener("click", MouseEv);
 
   var globSpeed=1;
   var headedOut=false;
   var fishColors=["blue", "darkBlue", "lightBlue","yellow","black"];
   function RandomColor(){return fishColors[Math.floor(Math.random()*fishColors.length)];}
   function Fish(){
      this.color1=RandomColor();
      if(this.color1 === "black"){this.color1="blue";}
      this.color2=RandomColor();
      this.color3=RandomColor();
      this.color4=RandomColor();
      this.x=Math.floor(Math.random()*2);
      this.dir=1;
      if(this.x){
         this.dir=-1;
      }
      this.y=Math.random();
      this.scale=Math.random()*40+40;
      this.speed=Math.random()*0.001+0.0005;
      this.waggle=0;
      this.waggle2=0;

   }
   Fish.prototype.DetectHit=function(){
      if(this.dir === 1){
         var rx=mainCanv.width*this.x;
         var lx=rx-this.scale;
      }else{
         lx=mainCanv.width*this.x;
         rx=lx+this.scale;
      }
      var y=this.y*mainCanv.height;
      var by=y+0.22777777777777777*this.scale;
      var ty=y-0.35*this.scale;
      if(mouseX<=rx && mouseX>=lx && mouseY<=by && mouseY>= ty){
         this.speed*=7;
      }
   };
   Fish.prototype.DRAW=function(f){
        this.x+=this.speed*f*this.dir*globSpeed;
        this.waggle+=(63*this.speed*globSpeed);
        this.waggle%=tau;
        this.waggle2+=(100*this.speed*globSpeed);
        this.waggle2%=tau;
        var waggleChange=Math.sin(this.waggle)/20;
        var waggleChange2=Math.sin(this.waggle2)/20;
	var x=this.x*mainCanv.width, y=this.y*mainCanv.height;
        if(this.dir === 1 && x-this.scale > mainCanv.width+10){
           return false;
        }else if(x+this.scale < -10){
           return false;
        }
	this.scale=this.scale || 1;
        mainCtx.save();
        if(this.dir === 1){x=mainCanv.width-x;mainCtx.translate(mainCanv.width, 0);mainCtx.scale(-1,1);}
	mainCtx.beginPath();
	mainCtx.moveTo(x+(0*this.scale),y+(0*this.scale));
	/* body */
	mainCtx.bezierCurveTo(x+(0.14444444444444443*this.scale),y+(0.03333333333333333*this.scale),x+(0*this.scale),y+(-0.37222222222222223*this.scale),x+(0.6166666666666667*this.scale),y+(-0.25555555555555554*this.scale));
	mainCtx.bezierCurveTo(x+(0.7777777777777778*this.scale),y+(-0.2222222222222222*this.scale),x+(0.7666666666666667*this.scale),y+(0.06666666666666667*this.scale),x+(0.6055555555555555*this.scale),y+(0.15*this.scale));
	mainCtx.bezierCurveTo(x+(0.15555555555555556*this.scale),y+(0.28888888888888886*this.scale),x+(0.25555555555555554*this.scale),y+(0.06666666666666667*this.scale),x+(0*this.scale),y+(0.03888888888888889*this.scale));
	mainCtx.closePath();
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	mainCtx.save();

        mainCtx.fillStyle=this.color1;
	mainCtx.fill();
	mainCtx.restore();
	/* Stripe 1*/
	mainCtx.beginPath();
	mainCtx.moveTo(x+(0.35*this.scale),y+(-0.2722222222222222*this.scale));
	mainCtx.bezierCurveTo(x+(0.4444444444444444*this.scale),y+(-0.05555555555555555*this.scale),x+(0.3111111111111111*this.scale),y+(-0.11666666666666667*this.scale),x+(0.3611111111111111*this.scale),y+(0.15*this.scale));
	mainCtx.bezierCurveTo(x+(0.36666666666666664*this.scale),y+(-0.022222222222222223*this.scale),x+(0.4666666666666667*this.scale),y+(-0.12222222222222222*this.scale),x+(0.39444444444444443*this.scale),y+(-0.2777777777777778*this.scale));
	mainCtx.closePath();
	/* Stripe 2 */
	mainCtx.moveTo(x+(0.46111111111111114*this.scale),y+(-0.2777777777777778*this.scale));
	mainCtx.bezierCurveTo(x+(0.5166666666666667*this.scale),y+(-0.1*this.scale),x+(0.46111111111111114*this.scale),y+(-0.14444444444444443*this.scale),x+(0.46111111111111114*this.scale),y+(0.17777777777777778*this.scale));
	mainCtx.bezierCurveTo(x+(0.48333333333333334*this.scale),y+(-0.005555555555555556*this.scale),x+(0.5388888888888889*this.scale),y+(-0.12222222222222222*this.scale),x+(0.5111111111111111*this.scale),y+(-0.2833333333333333*this.scale));
	mainCtx.save();
        mainCtx.fillStyle=this.color2;
	mainCtx.fill();
	mainCtx.restore();
	/* Back Fin */
	mainCtx.beginPath();
	mainCtx.moveTo(x+(0.7277777777777777*this.scale),y+(-0.14444444444444443*this.scale));
	mainCtx.bezierCurveTo(
           x+(1*this.scale),
           y+(-0.3333333333333333*this.scale),
           x+((0.8722222222222222+waggleChange)*this.scale),
           y+(-0.13333333333333333*this.scale),
           x+((0.8944444444444445+waggleChange)*this.scale),
           y+(-0.03888888888888889*this.scale)
        );
	mainCtx.bezierCurveTo(x+(0.9722222222222222*this.scale),y+(0.2222222222222222*this.scale),x+(0.85*this.scale),y+(-0.027777777777777776*this.scale),x+(0.7111111111111111*this.scale),y+(0.027777777777777776*this.scale));
	mainCtx.quadraticCurveTo(x+(0.7555555555555555*this.scale),y+(-0.06111111111111111*this.scale),x+(0.7277777777777777*this.scale),y+(-0.14444444444444443*this.scale));
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	mainCtx.save();

        mainCtx.fillStyle=this.color3;
	mainCtx.fill();
	mainCtx.restore();
	/* Top Fin */
	mainCtx.beginPath();
	mainCtx.moveTo(x+(0.25555555555555554*this.scale),y+(-0.2611111111111111*this.scale));
	mainCtx.bezierCurveTo(
          x+(0.6666666666666666*this.scale),
          y+((-0.4111111111111111+waggleChange2/4)*this.scale),
          x+(0.8111111111111111*this.scale),
          y+((-0.3333333333333333+waggleChange2/3)*this.scale),
          x+(0.5888888888888889*this.scale),
          y+((-0.26666666666666666)*this.scale)
        );
	mainCtx.quadraticCurveTo(x+(0.4888888888888889*this.scale),y+(-0.3055555555555556*this.scale),x+(0.25555555555555554*this.scale),y+(-0.2611111111111111*this.scale));
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	mainCtx.save();

        mainCtx.fillStyle=this.color3;
	mainCtx.fill();
	mainCtx.restore();
	/* Side Fin */
	mainCtx.beginPath();
	mainCtx.moveTo(x+(0.3111111111111111*this.scale),y+(0.044444444444444446*this.scale));
	mainCtx.bezierCurveTo(
          x+(0.3888888888888889*this.scale),
          y+((0.12777777777777777+waggleChange/3)*this.scale),
          x+(0.65*this.scale),
          y+((0.18333333333333332+waggleChange/3)*this.scale),
          x+(0.4222222222222222*this.scale), 
          y+(0.027777777777777776*this.scale)
        );
	mainCtx.closePath();
	/* Bottom Fin */
	mainCtx.moveTo(x+(0.32222222222222224*this.scale),y+(0.2*this.scale));
	mainCtx.bezierCurveTo(
           x+(0.5833333333333334*this.scale),
           y+((0.2777777777777778+waggleChange2/3)*this.scale),
           x+(0.8333333333333334*this.scale),
           y+((0.16666666666666666+waggleChange2/3)*this.scale),
           x+(0.6888888888888889*this.scale),
           y+(0.07222222222222222*this.scale)
        );
	mainCtx.quadraticCurveTo(x+(0.6166666666666667*this.scale),y+(0.18333333333333332*this.scale),x+(0.31666666666666665*this.scale),y+(0.19444444444444445*this.scale));
	mainCtx.save();
	mainCtx.lineWidth=2;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	mainCtx.save();

        mainCtx.fillStyle=this.color3;
	mainCtx.fill();
	mainCtx.restore();
	/* Eye Highlight*/
	mainCtx.beginPath();
	mainCtx.moveTo(x+(0.12777777777777777*this.scale),y+(-0.16666666666666666*this.scale));
	mainCtx.quadraticCurveTo(x+(0.24444444444444444*this.scale),y+(-0.1111111111111111*this.scale),x+(0.21666666666666667*this.scale),y+(0.1111111111111111*this.scale));
	mainCtx.quadraticCurveTo(x+(0.37777777777777777*this.scale),y+(-0.17777777777777778*this.scale),x+(0.25*this.scale),y+(-0.25555555555555554*this.scale));
	mainCtx.quadraticCurveTo(x+(0.16666666666666666*this.scale),y+(-0.23333333333333334*this.scale),x+(0.13333333333333333*this.scale),y+(-0.16666666666666666*this.scale));
	mainCtx.save();

        mainCtx.fillStyle=this.color4;
	mainCtx.fill();
	mainCtx.restore();
	/* Eye Socket */
	mainCtx.beginPath();
	mainCtx.arc(x+(0.2222222222222222*this.scale),y+(-0.13333333333333333*this.scale), 0.03333333333333333*this.scale, 0.05, 6.283, false);
	mainCtx.save();
	mainCtx.fillStyle="white";
	mainCtx.fill();
	mainCtx.restore();
	mainCtx.save();
	mainCtx.lineWidth=1;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();
	/* Eye Ball */
	mainCtx.beginPath();
	mainCtx.arc(x+(0.21666666666666667*this.scale),y+(-0.1388888888888889*this.scale), 0.016666666666666666*this.scale, 0, 6.283, false);
	mainCtx.save();
	mainCtx.lineWidth=1;
	mainCtx.strokeStyle="black";
	mainCtx.stroke();
	mainCtx.restore();

        mainCtx.restore();
        return true;
};

   var snubbedFrames = 0;
   
   
   function In(self,f, curView){
      if(curView !== cv){return Out;}
      snubbedFrames++;
      if(snubbedFrames < 30){return self;}
      globSpeed=2.5;
      if(fish.length<5){fish.push(new Fish());}
      fish=fish.filter(function(fi){return fi.DRAW(f);});
      
      if(snubbedFrames>100){
         return Loop;
      }

      return self;
   }
   function Loop(self,f, curView){
      globSpeed=1;
      
      if(mouseX !== null){
        fish.forEach(function(f){f.DetectHit();});
        mouseX=null; mouseY=null;
      }
      fish=fish.filter(function(fi){return fi.DRAW(f);});
      if(curView !== cv){return Out;}
      if(fish.length < 10 && !Math.floor(Math.random()*(fish.length))){
         fish.push(new Fish());
      }
      


      return self;
   }
   function Out(self, f, curView){
      globSpeed=25;
      
      fish=fish.filter(function(fi){return fi.DRAW(f);});
      if(!fish.length){
         removeEventListener("click", MouseEv);
         return false;
      }
      return self;
   }
   return In;
};
/*animationAssignment*/
AniFamilies.Music=AniFamilies.Software=AniFamilies.Math=AniFamilies.Face;
AniFamilies.Home=AniFamilies.Cubes;
AniFamilies.Contact=AniFamilies.Space;

AniFamilies.Jammaday=
AniFamilies.Factoring=
AniFamilies['Latest News Articles']=
AniFamilies['Apps and Libraries']=
AniFamilies['Social Media']=AniFamilies.Fish;

AniFamilies['My Salvation In Christ']=
AniFamilies.Credits=
AniFamilies.Mochobo=
AniFamilies['Unbalanced Algebra']=
AniFamilies['Tech Stack']=
AniFamilies['Web Apps Actualized']=AniFamilies.Clouds;
/*mediaControl*/
var MediaMenuOnClose=[];
function MediaMenu(p){
    if(p.DATA_mouseInit){p.dispatchEvent(new Event('click'));}
    CloseMediaMenu();
    document.body.style.width=document.body.clientWidth+'px';
    canvWrap.style.width=canvWrap.clientWidth+'px';
    document.documentElement.style.overflow="hidden";
    var ret={CLOSE:function(){history.back();}};
    _el.APPEND(document.body, ret.wrapper=_el.CREATE('div','mediaMenuWrapper','',{style:{height:'0'}},[
       ret.backer=_el.CREATE('div','mediaMenuBacker','',{},[]),
       ret.closer=_el.CREATE('div','mediaMenuCloser','',{onclick:function(){ret.CLOSE();}, onkeydown:function(e){AccKeydown(e,this);}, style:{opacity:0}, attributes:{role:'button', tabindex:'0', 'aria-label':'Close Menu', title:'Close Menu'}},[]),
       ret.client=_el.CREATE('div','mediaMenuClient','',{},[]),
    ]));
    setTimeout(function(){ret.wrapper.style.removeProperty('height'); ret.closer.style.removeProperty("opacity"); ret.closer.focus();},200);
    addEventListener('keydown', CloseMediaMenuOnEscape);
    return ret;
}
function CloseMediaMenuOnEscape(e){
   if(e.keyCode === 27){e.preventDefault();history.back();}
}
function CloseMediaMenu(){
   removeEventListener('keydown', CloseMediaMenuOnEscape);
   var f; while(f=MediaMenuOnClose.pop()){f();}
   var mod=document.querySelector("#mediaMenuWrapper");
    document.body.style.removeProperty('width');
    document.documentElement.style.removeProperty('overflow');
    canvWrap.style.removeProperty('width');
   _el.REMOVE(mod);
}



function OpenMenuFlag(tar,mouse){
   clearTimeout(tar.DATA_flagTimeout);
   
   var flag=tar.querySelector('.menuFlag');
   _el.MoveId('menuFlagOpen',flag);
   if(mouse){
      clearTimeout(tar.DATA_flagTouchCloseTimeout);
      tar.DATA_flagTouchCloseTimeout=setTimeout(function(){CloseMenuFlag(flag);},4500);
   }
}
function CloseMenuFlagEv(tar){
   var flag=tar.querySelector(".menuFlag");
   if(!flag){
      return;
   }
   tar.DATA_flagTimeout=setTimeout(function(){CloseMenuFlag(flag);},300);
}
function CloseMenuFlag(flag){
   flag.id='';
   flag.parentNode.DATA_mouseInit=false;
   flag.parentNode.DATA_justPlayed=false;
}
/*audioStuff*/
var audioTracks=[
   {
      name:"Jovie's Song",
      src:'/media/audios/Jovies-Song-2022/source.mp3'
   },
   {
      name:"Roscoe's Song",
      src:'/media/audios/Roscoes-Song-2022/source.mp3'
   },
   {
      name:"Jenna's Song",
      src:'/media/audios/Jenna-s-Song-2022/source.mp3'
   },
   {
      name:"It is What it Is",
      src:'/media/audios/It-is-What-it-Is-2022/source.mp3'
   },
   {
      name:"Pot of Gold",
      src:'/media/audios/Pot-of-Gold-2022/source.mp3'
   },
   {
      name:"Cassie's Song",
      src:'/media/audios/Cassies-Song-2022/source.mp3'
   },
   {
      name:"Sick of the Scene",
      src:'/media/audios/Sick-of-the-Scene-2022/source.mp3'
   },
   {
      name:"Top of the World (Live)",
      src:'/media/audios/Top-of-The-World--2022-(Live)/source.mp3'
   },
   {
      name:"Alone with Regret",
      src:'/media/audios/Alone-with-Regret-2022/source.mp3'
   },
   {
      name:"Dynamo Monkey",
      src:'/media/audios/Dynamo-Monkey-2022/source.mp3'
   },
   {
      name:"I've got a Woman",
      src:'/media/audios/I-ve-Got-a-Woman-2022/source.mp3'
   },
   {
      name:"Nothing to Loose (Live)",
      src:'/media/audios/Nothing-to-Loose-(Live)-2022/source.mp3'
   },
   {
      name:"Rain",
      src:'/media/audios/Rain-2022/source.mp3'
   },
];
var defaultAudioSettings={
   masterVolume:1,
   musicVolume:1,
   soundEffectVolume:1,
   disabled:0,
   tracks:{},
   currentTrack:0
};
audioTracks.forEach(function(a){
   defaultAudioSettings.tracks[a.name]={
      include:true
   };
});

function ResumeAudio(){
   if(!mainAudio.src){currentAudioSettings.currentTrack--; return SetTrack();}
   if(currentAudioSettings.tracks[audioTracks[currentAudioSettings.currentTrack].name].include){
      
      mainAudio.play().catch(function(e){});
   }else{SetTrack();}
}
function SetTrack(name){
   var cS=currentAudioSettings;
   var found=false;
   if(!name){
      var rounds=0;
      while(rounds < audioTracks.length+1)
      {
         rounds++;
         cS.currentTrack++;
         cS.currentTrack%=audioTracks.length;
         if(cS.tracks[audioTracks[cS.currentTrack].name].include){
             found=true;
             break;
         }
      }
   }else{
      var tempTrack=audioTracks.findIndex(function(a){return a.name === name;});
      found=tempTrack > -1;
      if(found){cS.currentTrack=tempTrack;}
   }
   if(!found){return;}
   var tList;
             mainAudio.src=audioTracks[cS.currentTrack].src;
             if(audioHasPlayed){
                mainAudio.play().catch(function(e){});
             }
             SetAudio(cS);
   if(tList=document.querySelector('#audioTrackNameListener')){
      _el.EMPTY(tList);
      _el.APPEND(tList, audioTracks[cS.currentTrack].name);
   }
}


var currentAudioSettings=localStorage.getItem('mainAudioSettings');
currentAudioSettings=JSON.parse(currentAudioSettings || '{}');
currentAudioSettings=_ob.COMBINE(defaultAudioSettings,currentAudioSettings);

audioTracks.forEach(function(t){if(!currentAudioSettings.tracks[t.name]){currentAudioSettings.tracks[t.name]={include:true};}});

var mainAudio=new Audio();
mainAudio.preload="none";
mainAudio.onplay=function(){audioHasPlayed=true; document.documentElement.classList.add('audioHasPlayed'); document.documentElement.classList.add('audioIsPlaying');};
mainAudio.onended=function(){SetTrack();};
mainAudio.onpause=function(){document.documentElement.classList.remove('audioIsPlaying');};
mainAudio.onsuspend=mainAudio.oncanplay=function(){document.documentElement.classList.remove("audioLoading");};
mainAudio.onloadstart=function(){document.documentElement.classList.add("audioLoading");};
var audioHasPlayed=false;
mainAudio.volume=currentAudioSettings.masterVolume*currentAudioSettings.musicVolume*(!currentAudioSettings.disabled);
VCR.main.REGISTER_changeANDrelease(function(){if(!audioHasPlayed){ResumeAudio();}});
addEventListener('load',function(){ResumeAudio();});


function OpenAudioMenu(flag){
   CloseMenuFlagEv(flag.parentNode);
   var mod=MediaMenu(flag.parentNode);
   var muteAllCheck, masterVolume, musicVolume, soundEffectVolume;
   mod.client.oninput=function(){
      SetAudio(COLL());
   };
   
   function COLL(){
      var trackOb={};
      Array.from(document.querySelectorAll('.trackChecks')).forEach(function(t){
         trackOb[t.DATA_trackName]={include:t.checked};
      });
      return {
         disabled:muteAllCheck.checked,
         masterVolume:masterVolume.value,
         musicVolume:musicVolume.value,
         soundEffectVolume:soundEffectVolume.value,
         tracks:trackOb
      };
   }
   var temp;
   var clickCaptured=false;
   
   function MouseUp(e){
      if(!clickCaptured){return;}
      clickCaptured=false;
      var l=parseFloat(playerTrackBall.style.left) || 0;
      mainAudio.currentTime=mainAudio.duration*l/(playerTrack.clientWidth-playerTrackBall.clientWidth);
   }
   function MouseMove(e){
      if(!clickCaptured){return;}
       
      if (window.getSelection) {window.getSelection().removeAllRanges();}
      else if (document.selection) {document.selection.empty();}
      var trackOffset=playerTrack.getBoundingClientRect();
      playerTrackBall.style.left=Math.min(Math.max(e.clientX-trackOffset.x, 0), playerTrack.clientWidth-playerTrackBall.clientWidth)+'px';
   }
   function OnTimeUpdate(){
      var t=mainAudio.currentTime;
      if(clickCaptured){return;}
      playerTrackBall.style.left=(t*(playerTrack.clientWidth-playerTrackBall.clientWidth)/mainAudio.duration)+'px';
      playerCurrentTime.innerHTML=""+SecondsToTrackTime(mainAudio.currentTime);
      playerTimeLeft.innerHTML=''+SecondsToTrackTime(mainAudio.duration-mainAudio.currentTime);
   }
   var playerTrack, playerTrackBall, playerCurrentTime, playerTimeLeft;
   mainAudio.addEventListener('timeupdate',OnTimeUpdate);
   addEventListener('mousemove',MouseMove);
   addEventListener('mouseup',MouseUp);
   MediaMenuOnClose.push(function(){mainAudio.removeEventListener('timeupdate',OnTimeUpdate);removeEventListener('mouseup',MouseUp);removeEventListener('mousemove', MouseMove);});
   
   _el.APPEND(mod.client, temp=_el.CREATE('div','','prettyMargin',{},[_el.CREATE('div','','prettyMarginInner',{},[])]));
   mod.client=temp;
   _el.APPEND(mod.client, [
      _el.CREATE('h3','','',{},["Audio Settings"]),
      _el.CREATE('div','','',{},[
         _el.CREATE('label','','',{},[
            "Mute All: ",
            muteAllCheck=_el.CREATE('input','','',{name:'muteAll',type:'checkbox', checked:currentAudioSettings.disabled})
         ]),
         _el.CREATE('br'),
         _el.CREATE('label','','',{},[
            "Master Volume: ",
            masterVolume=_el.CREATE('input','','',{name:'masterVolume',type:'range', min:'0', max:'1', step:'0.01', value:currentAudioSettings.masterVolume})
         ]),
         _el.CREATE('br'),
         _el.CREATE('label','','',{},[
            "Music Volume: ",
            musicVolume=_el.CREATE('input','','',{name:'musicVolume',type:'range', min:'0', max:'1', step:'0.01', value:currentAudioSettings.musicVolume})
         ]),
         _el.CREATE('br'),
         _el.CREATE('label','','',{},[
            "Sound Effect Volume: ",
            soundEffectVolume=_el.CREATE('input','','',{name:'soundFxVolume',type:'range', min:'0', max:'1', step:'0.01', value:currentAudioSettings.soundEffectVolume})
         ]),
      ]),
      _el.CREATE('hr'),
      _el.CREATE('h3','','',{},["Now Playing"]),
      _el.CREATE('h4','audioTrackNameListener','',{},[(currentAudioSettings.tracks[audioTracks[currentAudioSettings.currentTrack].name].include ? audioTracks[currentAudioSettings.currentTrack].name : 'None Selected')]),
      _el.CREATE('div','','',{},[
         playerCurrentTime=_el.CREATE('span','audioPlayerCurrentTime','',{},[''+SecondsToTrackTime(mainAudio.currentTime || 0)]),
         playerTrack=_el.CREATE('div','audioPlayerTrack','',{
            
         },[
            playerTrackBall=_el.CREATE('div','','',{
               attributes:{role:'button', title:'Seek Audio', 'aria-label':'Audio Seeker (Use Keyboard Left and Right)', tabindex:'0'},
               onkeydown:function(e){
                  if(e.keyCode === 37){mainAudio.currentTime=Math.max(0, (mainAudio.currentTime-1) || 0);e.preventDefault();}else if(e.keyCode === 39){mainAudio.currentTime=Math.min(mainAudio.duration || 0, (mainAudio.currentTime+1) || 0);e.preventDefault();}
               },
               onmousedown:function(){clickCaptured=true;},
               ontouchstart:function(e){
                  e.preventDefault();
                  clickCaptured=true;
               },
               ontouchmove:function(e){
                  e.preventDefault();
                  document.documentElement.dispatchEvent(new MouseEvent('mousemove',_ob.COMBINE(e.targetTouches[0], {bubbles:true})));
               },
               ontouchend:function(e){
                  e.preventDefault();
                  document.documentElement.dispatchEvent(new MouseEvent('mouseup',{bubbles:true}));
               }
            },[])
         ]),
         playerTimeLeft=_el.CREATE('span','audioPlayerTimeLeft','',{},[''+(SecondsToTrackTime((mainAudio.duration-mainAudio.currentTime) || 0))]),
         _el.CREATE('br'),
         _el.CREATE('button','','audioManipulateButton audioPlayerButtons',{onclick:function(){
            if(mainAudio.paused){
               if(!mainAudio.src){return SetTrack();}
               mainAudio.play();
               document.documentElement.classList.add("audioHasPlayed");
            }else{
               mainAudio.pause();
               document.documentElement.classList.remove("audioHasPlayed");
            }
         }},[""]),
         _el.CREATE('button','','audioPlayerButtons',{onclick:function(){SetTrack();}},["Next"])
      ]),
      _el.CREATE('hr'),
      _el.CREATE('h3','','',{},['Tracks']),
      _el.CREATE('h4','','',{},['Check the Box to Include in Playlist']),
      _el.CREATE('div','tracksContainer','',{},audioTracks.map(function(a){
         var c;
         return _el.CREATE('div','','audioTrackWrapper',{},[

            c=_el.CREATE('input','','trackChecks',{name:a.name+'_include',type:'checkbox', DATA_trackName:a.name, checked:currentAudioSettings.tracks[a.name].include}),
            " "+a.name+" ",
            _el.CREATE('button','','',{onclick:function(){
               c.checked=true;
               SetTrack(a.name);
               SetAudio(COLL());
               mainAudio.play();
            }},["Play Now"])

         ]);
      })),
   ]);
   playerTrackBall.style.left=(((playerTrack.clientWidth-playerTrackBall.clientWidth)*mainAudio.currentTime/mainAudio.duration) || 0)+'px';
   setTimeout(function(){muteAllCheck.checked=currentAudioSettings.disabled;},100);
}
function SecondsToTrackTime(s){
   s=parseInt(s) || 0;
   return (Math.floor(s/60) || 0)+":"+((''+(s%60 || 0)).padStart(2,'0'));
}
function ToggleAudio(){
    var j=localStorage.getItem('mainAudioSettings');
   j=JSON.parse(j || '{}');
   SetAudio({disabled:!j.disabled});
}
function SetAudio(ob){
   var docElem=document.documentElement;
   var j=currentAudioSettings;

   ob=_ob.COMBINE(j,ob);
   if(!ob.disabled){
      docElem.classList.remove('disableAudio');
   }else{
      docElem.classList.add('disableAudio');
   }
   currentAudioSettings=ob;
   localStorage.setItem('mainAudioSettings', JSON.stringify(ob));
   var vol=currentAudioSettings.masterVolume*currentAudioSettings.musicVolume*(!currentAudioSettings.disabled);
   mainAudio.volume=vol;
   if(!vol){mainAudio.muted=true;}else{mainAudio.muted=false;}
   
}


function AudioButtonClickEv(but){
   if(!document.querySelector('.audioHasPlayed')){
      but.DATA_justPlayed=true;
      ResumeAudio();
      SetAudio({disabled:false});
      return;
   }
   ToggleAudio();
}
/*graphicsStuff*/
function OpenGraphicsMenu(flag){
   CloseMenuFlagEv(flag.parentNode);
   function COLL(){
      return {
         disabled:disCheck.checked
      };
   }
   var disCheck;
   var mod=MediaMenu(flag.parentNode);
   mod.client.onchange=function(){
      SetGraphics(COLL());
   };
   var gs=localStorage.getItem('mainGraphicsSettings');
   gs=JSON.parse(gs || '{}');
   
   var temp;
   _el.APPEND(mod.client, temp=_el.CREATE('div','','prettyMargin',{},[_el.CREATE('div','','prettyMarginInner',{},[])]));
   mod.client=temp;
   _el.APPEND(mod.client,[
      _el.CREATE('h3','','',{},["Graphics Options"]),
      _el.CREATE('div','','',{},[
         _el.CREATE('label','','',{},[
            "Disable Grapics: ",
            disCheck=_el.CREATE('input','','',{name:'disableGraphics',type:'checkbox', checked:gs.disabled})
         ])
      ])
   ]);
   if(gs.page){
      var descCat;
      _el.APPEND(mod.client, descCat=_el.CREATE('div','graphicsDescriptionCatcher'));
      _el.APPEND(descCat,[
         _el.CREATE('h3','','',{},["On This Page: "+gs.page.name]),
         _el.CREATE('h4','','',{},[gs.page.description || ''])
      ]);
      if(gs.page.interactivity && gs.page.interactivity.length){
        _el.APPEND(descCat, [
           _el.CREATE('hr'),
           _el.CREATE('div','interactivityWrapper','',{},[
              _el.CREATE('h3','interactivityLabel','',{},["Interactivity"]),
              _el.CREATE('ul','','',{},gs.page.interactivity.map(function(i){
                 return _el.CREATE('li','','',{},[i || '']);
              }))
           ])
        ]);
      }
   }
   setTimeout(function(){
     var gs=localStorage.getItem('mainGraphicsSettings');
     gs=JSON.parse(gs || '{}');
     disCheck.checked=gs.disabled;
   },100);
}
function ToggleGraphics(){
      var j=localStorage.getItem('mainGraphicsSettings');
   j=JSON.parse(j || '{}');
   SetGraphics({disabled:!j.disabled});
}
function SetGraphics(ob){
   var docElem=document.documentElement;
   var j=localStorage.getItem('mainGraphicsSettings');
   j=JSON.parse(j || '{}');
   ob=_ob.COMBINE(j,ob);
   if(!ob.disabled){
      docElem.classList.remove('disableGraphics');
   }else{
      docElem.classList.add('disableGraphics');
   }
   localStorage.setItem('mainGraphicsSettings', JSON.stringify(ob));
}
/*factoring*/
var FactoritState={
   registerChangeNeeded:true,
   factIndex:0,
   timeout:0,
   runTimeout:0,
   submitTimeout:0,
   mainFactArr:[],
   factSaves:{},
   factStack:[],
   n:0,
   Submit:function(n){
      if(this.registerChangeNeeded){
         this.registerChangeNeeded=false;
         VCR.main.REGISTER_changeANDrelease(function(){
            th.factIndex++;
            th.registerChangeNeeded=true;
            clearTimeout(th.timeout);
            clearTimeout(th.runTimeout);
            clearTimeout(th.submitTimeout);
         });
      }
      clearTimeout(this.submitTimeout);
      clearTimeout(this.runTimeout);
      clearTimeout(this.timeout);
      var th=this;
      
      n=parseInt(n);
      
      if(!n){
         return this.Finish("Invalid Number", true);
      }
      n=Math.abs(n);
      this.n=n;
      var limited=document.querySelector('#factorSafeSizeLimits').checked;
      var softMax=999999999;
      var hardMax=35184372088832;

      if(limited){
         if(n>softMax){
            return this.Finish("Number out of Range", true);
         }
      }else{
         if(n>hardMax){
            return this.Finish("Even with limits disabled, there is still a limit to the size of numbers readily available in a web browser. The number provided is out of range.", true);
         }
      }


      
      this.factStack=[];
      this.factIndex++;
      this.mainFactArr=[n];
      this.submitTimeout=setTimeout(function(){th.Check(th.factIndex);},100);
      _el.EMPTY(document.getElementById("factoringResult"));
      _el.APPEND(document.getElementById("factoringResult"),[
         _el.CREATE('div','','factorWaitTextSpinner',{},[
            _el.CREATE('div','','factoringWaitText',{},[
               "Factoring: "+n
            ])
         ]),
         _el.CREATE('div','','factoringWaitText',{},[
             _el.CREATE('button','','',{onclick:function(){
                var el=document.getElementById('integerInput');
                el.value='1'; el.dispatchEvent(new Event('change'));
             }},['Cancel'])
         ])
      ]);
   },
   Check:function(factIndex){
      if(factIndex !== this.factIndex){return;}
      var th=this;
      this.mainFactArr=this.mainFactArr.map(function(f){return parseInt(f);});
      var firstNot=this.mainFactArr.find(function(n){
         return th.factSaves[n] !== 'PRIME';
      });
      if(firstNot){
         this.runTimeout=setTimeout(function(){
            th.Factor(factIndex,firstNot);
         }, 10); 
         return;
      }
      var isPrime=false;
      if(this.mainFactArr.length === 1){
         this.mainFactArr.push(1);
         isPrime=true;
      }
      this.mainFactArr.sort(function(a,b){return a-b;});
      this.Finish(this.n+' = '+this.mainFactArr.join(' x ')+(isPrime ? " ("+this.n+" is Prime)" : ''));
   },
   Factor:function(factIndex,n){
      if(factIndex !== this.factIndex){return;}
      var fs;
      if(fs=this.factSaves[n]){
         if(fs === "PRIME"){
            alert("Check Error");return;
         }
         var ind=this.mainFactArr.indexOf(n);
         var arr=[ind,1].concat(fs.split('x'));
         this.mainFactArr.splice.apply(this.mainFactArr, arr);
         return this.Check(factIndex);
      }
      var cutoff=Math.floor(n/10000);
      
      var sr=Math.sqrt(n);
      var bottom=Math.floor(sr), top=Math.ceil(sr);
      var tot=bottom*top;
      this.Algorithm(factIndex,bottom, top, tot, n,0, cutoff,true);
   },
   Breath:function(factIndex,x,y,t,n, cutoff){
      if(factIndex !== this.factIndex){return;}
      var th=this;
      this.timeout=setTimeout(function(){th.Algorithm(factIndex,x,y,t,n,0,cutoff);},25);
   },
   Algorithm:function(factIndex,x,y,t,n,calls,cutoff,runFirst){
      if(factIndex !== this.factIndex){return;}
      calls++;
      if(runFirst){
         if(this.First(n)){
            return this.Check(factIndex);
         }
      }
      

      if(x === 1){
         this.factSaves[n]="PRIME";
         
         return this.Check(factIndex);
      }
      if(x <= 0 || y <= 0){
         return this.Finish("Error",true);
      }
      
      if(x < cutoff){
         return this.Fallback(factIndex,n,cutoff);
      }
      if(t<n){
         if(calls < 1500){
            this.Algorithm(factIndex,x,y+1,t+x,n,calls,cutoff);
         }else{
            this.Breath(factIndex,x,y+1,t+x,n,cutoff);
         }
         return;
      }
      if(t>n){
         if(calls < 1500){
            this.Algorithm(factIndex,x-1,y,t-y,n,calls,cutoff);
         }else{
            this.Breath(factIndex,x-1,y,t-y,n,cutoff);
         }
         return;
      }

      this.factSaves[n]=x+"x"+y;
      this.Check(factIndex);
      
   },
   First:function(n){
      var act=[2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97, 101, 103, 107, 109, 113, 127];
      var found=act.find(function(a){return !(n%a);});
      if(found){
         if(found === n){
            this.factSaves[n]="PRIME";
         }else{
            this.factSaves[n]=found+"x"+parseInt(n/found);
         }
         return true;
      }
      return false;
   },
   FallbackString:function(factIndex, n, cutoff, cutArr, cutInd, i){
      if(factIndex !== this.factIndex){return;}
      
      for(var k=0; k< 150 && i<=cutoff; i++, k++)
      {
          cutInd=cutInd.map(function(v, ind){v++; v%=cutArr[ind]; return v;});
          if(cutInd.indexOf(0) < 0){
             cutArr.push(i);
             cutInd.push(0);
             if(!(n%i)){this.factSaves[n]=i+"x"+parseInt(n/i); return this.Check(factIndex);}
          }
      }
      if(i>=cutoff){
         this.factSaves[n]="PRIME";
         return this.Check(factIndex);
      }
      var th=this;
      this.runTimeout=setTimeout(function(){
         th.FallbackString(factIndex, n, cutoff,cutArr, cutInd,i);
      }, 25);
   },
   Fallback:function(factIndex,n,cutoff){
      if(factIndex !== this.factIndex){return;}
     
      var cutArr=[2,3];
      var cutInd=[0,1];
      this.FallbackString(factIndex, n, cutoff, cutArr, cutInd, 5);
     
   },
   Finish:function(m, er){
       if(er){
          m='<span class="factoringError">'+m+'';
       }
       document.querySelector('#factoringResult').innerHTML=m;
   }
};
/*menuVCR*/
VCR.menus=new VC();
VCR.menus.active=true;

if(history.state && history.state.VCR && history.state.VCR.menus){
   var cv=(history.state.VCR.menus.view) || 0;
   if(cv){
      VCR.menus.CAPTURE(VCR.main);
      addEventListener('load',function(){VCR.menus.LAUNCH(cv);});
   }
};
VCR.menus.REGISTER_view('home',function(a){
   CloseMediaMenu();   
});
VCR.menus.REGISTER_view('audio',function(a){
   _hist.documentTitle="Audio Menu";
   OpenAudioMenu(document.getElementById("audioMenuFlag").parentNode);
});
VCR.menus.REGISTER_view('graphics', function(a){
   _hist.documentTitle="Graphics Menu";
   OpenGraphicsMenu(document.getElementById('graphicsMenuFlag').parentNode);
});
/*ImageInteractionFunct*/
function FastXSpin(el){
   var i=el.querySelector('img');
   i.classList.remove('fastXImage');
   setTimeout(function(){i.classList.add('fastXImage');},1);
}
function FastZSpin(el){
   var i=el.querySelector('img');
   i.classList.remove('fastZImage');
   setTimeout(function(){i.classList.add('fastZImage');},1);
}
function ScaleImgOut(el){
   var i=el.querySelector('img');
   el.onclick=function(){ScaleImgIn(this);};
   i.classList.add('transformTransImg');
 
   i.classList.add('imgScaleIn');

   setTimeout(function(){i.classList.add('imgScaleOut');i.classList.remove('imgScaleIn');},1);
}
function ScaleImgIn(el){
   var i=el.querySelector('img');
   i.classList.add('transformTransImg');
   el.onclick=function(){ScaleImgOut(this);};

   setTimeout(function(){i.classList.add('imgScaleIn');i.classList.remove('imgScaleOut');},1);
}
/*accessibilityKeydown*/
function AccKeydown(e, el, nm){
   if([' ','Spacebar','Enter'].indexOf(e.key) === -1){
      return;
   }
   _el.CancelEvent(e);
   if(nm){
      el.dispatchEvent(new Event(nm));
   }else{
      el.dispatchEvent(new Event('touchstart'));
      el.dispatchEvent(new Event('click'));
   }
   
}
/*cookieManagerSetting*/
CookieManager.autoRender=false;</script>
<style>.DynamicSection-Loading {
  font-size: 110%;
  font-style: italic;
}
.DynamicSection-Loading > span:first-child {
  animation: 2s 0s infinite alternate DynamicSection-LoadingSpin;
  margin-right: 4px;
  display: inline-block;
}
.DynamicSection-Loading > span:last-child {
  animation: 2s 1s infinite alternate DynamicSection-LoadingSpin;
  margin-left: 4px;
  display: inline-block;
}
@keyframes DynamicSection-LoadingSpin {
  from {
    transform: rotateY(0deg);
  }
  to {
    transform: rotateY(360deg);
  }
}
.DynamicBlog-Header {
  font-weight: bold;
  font-size: 125%;
}
.DynamicBlog-Card {
  display: inline-block;
  padding: 12px;
  margin: 12px;
  border: 2px solid orange;
  background-color: #cccccc;
}
#CookieManager-Interface {
  position: fixed;
  text-align: center;
  transition: height 0.5s;
  bottom: 0;
  left: 0;
  width: 100%;
  max-height: 100%;
  box-sizing: border-box;
  padding: 8px;
  background-color: #FAF9F6;
  z-index: 100;
  overflow-y: auto;
  border: 1px solid maroon;
  color: black;
}
#CookieManager-Interface p {
  text-align: left;
}
#CookieManager-CloseHolder {
  text-align: right;
  padding: 3px;
  position: sticky;
  top: 0;
  height: 0;
}
#CookieManager-ButtonHold > button {
  margin: 8px;
}
#CookieManager-Details {
  padding: 8px;
}
#CookieManager-Details:not(:empty) {
  border-top: 3px solid yellow;
  padding-bottom: 20vh;
}
.CookieManager-CookieDetails,
.CookieManager-Manager-Cookie {
  display: inline-block;
  box-sizing: border-box;
  padding: 8px;
  margin-top: 5px;
  margin-bottom: 5px;
  width: 90%;
}
.CookieManager-CookieDetails p,
.CookieManager-Manager-Cookie p {
  font-size: 100%;
}
.CookieManager-PermissionPlaceholder details[open],
.CookieManager-Manager-Category details[open] {
  border: 1px solid gold;
  display: inline-block;
  padding: 8px;
  width: 98%;
  box-sizing: border-box;
  border-radius: 25px;
  max-width: 620px;
}
.CookieManager-PermissionPlaceholder details,
.CookieManager-Manager-Category details {
  margin-top: 8px;
}
.CookieManager-PermissionPlaceholder details summary::before {
  content: 'See Details';
}
.CookieManager-PermissionPlaceholder details[open] summary::before {
  content: 'Hide Details';
}
.CookieManager-PermissionPlaceholder button {
  margin: 8px;
}
.CookieManager-Manager-Category details summary::before {
  content: 'See Cookies';
}
.CookieManager-Manager-Category details[open] summary::before {
  content: 'Hide Cookies';
}
.CookieManager-Manager-Category label {
  margin: 4px;
}
.CookieManager-Manager-Category:not(:first-of-type) {
  border-top: 3px solid black;
  margin-top: 9px;
}
.CookieManager-Manager-Cookie {
  border-top: 1px solid lightBlue;
  border-bottom: 1px solid lightBlue;
}
#CookieManager-Submit {
  position: fixed;
  right: 25px;
  bottom: 1%;
  cursor: pointer;
  padding: 8px;
  background-color: pink;
  border: 2px solid gold;
  z-index: 101;
}
#cookieManagerButtonWrapper {
  padding: 15px;
}
#cookieManagerButtonWrapper button {
  padding: 5px;
}
.SoftNotification-Wrapper {
  background-color: lightBlue;
  border: 2px solid orange;
  border-radius: 10px;
  position: fixed;
  bottom: 1%;
  right: 1%;
  max-width: 300px;
  padding: 8px;
  transition: opacity 500ms;
  color: black;
}
.SoftNotification-ActionWrapper {
  text-align: right;
  padding: 2px;
  margin-bottom: 3px;
}
.SoftNotification-BodyWrapper {
  padding: 2px;
}
body {
  background-color: seashell;
  padding: 0;
  margin: 0;
  text-align: center;
}
article {
  text-align: left;
}
img,
picture {
  max-width: 100%;
  height: auto;
}
p {
  text-align: left;
  text-indent: 10px;
  font-size: 150%;
}
nav {
  padding: 8px;
  display: inline-block;
  max-width: 775px;
}
#navWrapper {
  background-color: lightGray;
}
footer {
  background-color: #333333;
  padding: 8px;
  color: white;
  margin-top: 9px;
}
main {
  min-height: 100vh;
}
.invisiAnchors {
  color: inherit;
  text-decoration: none;
}
.prettyMargin {
  width: 98%;
  display: inline-block;
  max-width: 775px;
}
.prettyMarginInner {
  position: relative;
}
.continueButtons {
  padding: 3px;
  margin: 12px;
  background-color: white;
  border: 8px outset orange;
  display: inline-block;
}
.basicNavButton {
  display: inline-block;
  padding: 8px;
  margin: 5px;
  cursor: pointer;
  background-color: lightBlue;
  color: black;
  user-select: none;
}
.footerNav div {
  padding: 10px;
  display: inline-block;
  list-style: none;
}
.footerNav a {
  color: white;
}
.footerNav a:visited {
  color: white;
}
.footerNav::before {
  content: "Explore";
}
.lefty {
  text-align: left;
}
.activeView-Home #viewButton-Home,
.activeView-Music #viewButton-Music,
.activeView-Software #viewButton-Software,
.activeView-Math #viewButton-Math,
.activeView-Jammaday #viewButton-Jammaday,
.activeView-Mochobo #viewButton-Mochobo,
.activeView-Factoring #viewButton-Factoring,
.activeView-Unbalanced-Algebra #viewButton-Unbalanced-Algebra,
.activeView-Tech-Stack #viewButton-Tech-Stack,
.activeView-Apps-and-Libraries #viewButton-Apps-and-Libraries,
.activeView-Web-Apps-Actualized #viewButton-Web-Apps-Actualized,
.activeView-Contact #viewButton-Contact,
.activeView-Credits #viewButton-Credits,
.activeView-Latest-News-Articles #viewButton-Latest-News-Articles,
.activeView-Social-Media #viewButton-Social-Media,
.activeView-My-Salvation-In-Christ #viewButton-My-Salvation-In-Christ,
.activeView-siteNav #viewButton-siteNav {
  border: 4px solid gold;
}
#navWrapper {
  position: sticky;
  top: 0;
}
#navWrapper nav > header {
  display: none;
}
a:empty {
  display: none;
}
main nav {
  display: none;
}
.appButtons {
  background-color: lightBlue;
  padding: 4px;
  position: fixed;
}
.appButton-contents {
  display: none;
}
.hideAppButton {
  display: none;
}
#appButton-back {
  border-radius: 33%;
  padding: 8px;
  top: 70px;
  opacity: 1;
  transition: opacity 0.5s, top 0.5s;
}
.activeView-Home #appButton-back-content0 {
  display: block;
}
.activeView-Music #appButton-back-content0 {
  display: block;
}
.activeView-Software #appButton-back-content0 {
  display: block;
}
.activeView-Math #appButton-back-content0 {
  display: block;
}
.activeView-Jammaday #appButton-back-content0 {
  display: block;
}
.activeView-Mochobo #appButton-back-content0 {
  display: block;
}
.activeView-Factoring #appButton-back-content0 {
  display: block;
}
.activeView-Unbalanced-Algebra #appButton-back-content0 {
  display: block;
}
.activeView-Tech-Stack #appButton-back-content0 {
  display: block;
}
.activeView-Apps-and-Libraries #appButton-back-content0 {
  display: block;
}
.activeView-Web-Apps-Actualized #appButton-back-content0 {
  display: block;
}
.activeView-Contact #appButton-back-content0 {
  display: block;
}
.activeView-Credits #appButton-back-content0 {
  display: block;
}
.activeView-Latest-News-Articles #appButton-back-content0 {
  display: block;
}
.activeView-Social-Media #appButton-back-content0 {
  display: block;
}
.activeView-My-Salvation-In-Christ #appButton-back-content0 {
  display: block;
}
.activeView-siteNav #appButton-back {
  display: none;
}
main {
  position: relative;
}
#navWrapper,
#hamburger {
  z-index: 1;
}
.aniRest2 #contentTarget1,
.aniRest1 #contentTarget2 {
  position: absolute;
}
#contentTarget1,
#contentTarget2 {
  display: inline-block;
  width: 100%;
}
footer {
  position: relative;
  opacity: 1;
  transition: opacity 0.2s;
}
.aniAni1-2 footer,
.aniAni2-1 footer {
  opacity: 0;
  transition: opacity 0s;
}
#contentTarget1,
#contentTarget2 {
  transition: opacity 1s;
}
.aniPre1-2 #contentTarget1,
.aniPre2-1 #contentTarget2 {
  opacity: 1;
  position: relative;
}
.aniPre1-2 #contentTarget2,
.aniPre2-1 #contentTarget1 {
  opacity: 0;
  position: absolute;
  min-height: 100vh;
  top: 0;
  left: 0;
}
.aniAni1-2 #contentTarget1,
.aniAni2-1 #contentTarget2 {
  opacity: 0;
  position: relative;
}
.aniAni1-2 #contentTarget2,
.aniAni2-1 #contentTarget1 {
  opacity: 1;
  min-height: 100vh;
  position: absolute;
  top: 0;
  left: 0;
}
.aniRest2 #contentTarget1,
.aniRest1 #contentTarget2 {
  position: absolute;
  height: 0;
  opacity: 0;
}
.aniRest2 #contentTarget2,
.aniRest1 #contentTarget1 {
  opacity: 1;
}
@media screen and (max-width: 320px) {
  /*main>*:first-child{
		margin-top:9vh;
	}*/
}
@media screen and (max-width: 768px) {
  /*main h1:first-of-type{
		max-width:85%;
	}*/
  #navWrapper {
    background-color: transparent;
    width: 0;
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    overflow: hidden;
    transition: width 0.3s;
  }
  .navActive {
    overflow: hidden;
  }
  .navActive #navWrapper {
    width: 100%;
  }
  #navWrapper nav > header {
    display: block;
    text-align: right;
    border-bottom: 3px solid yellow;
    margin-top: 1%;
  }
  #navBacker {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.5;
    background-color: black;
  }
  nav {
    background-color: lightGray;
    display: block;
    text-align: left;
    position: relative;
    width: 75vw;
    max-height: 98%;
    overflow: auto;
    box-sizing: border-box;
    padding-bottom: 20vh;
  }
  nav > a {
    display: block;
  }
  main nav {
    width: 60vw;
    overflow: hidden;
    background-color: transparent;
    display: block;
  }
  main nav a {
    display: inline-block;
  }
  .navActive main nav {
    display: none;
  }
  main .basicNavButton {
    z-index: -1;
    display: inline-block;
  }
  .basicNavButton {
    background-color: transparent;
    position: relative;
    text-align: center;
    min-width: 100px;
    transition: left 0.2s;
    left: 0;
    margin-top: 15px;
  }
  .basicNavButton::AFTER {
    content: '';
    position: absolute;
    width: 80%;
    height: 3px;
    background-color: grey;
    top: 104%;
    left: 10%;
    border-radius: 2px;
  }
  .activeView-Home #viewButton-Home,
  .activeView-Music #viewButton-Music,
  .activeView-Software #viewButton-Software,
  .activeView-Math #viewButton-Math,
  .activeView-Jammaday #viewButton-Jammaday,
  .activeView-Mochobo #viewButton-Mochobo,
  .activeView-Factoring #viewButton-Factoring,
  .activeView-Unbalanced-Algebra #viewButton-Unbalanced-Algebra,
  .activeView-Tech-Stack #viewButton-Tech-Stack,
  .activeView-Apps-and-Libraries #viewButton-Apps-and-Libraries,
  .activeView-Web-Apps-Actualized #viewButton-Web-Apps-Actualized,
  .activeView-Contact #viewButton-Contact,
  .activeView-Credits #viewButton-Credits,
  .activeView-Latest-News-Articles #viewButton-Latest-News-Articles,
  .activeView-Social-Media #viewButton-Social-Media,
  .activeView-My-Salvation-In-Christ #viewButton-My-Salvation-In-Christ,
  .activeView-siteNav #viewButton-siteNav {
    border: none;
    left: 10%;
    border-bottom: 3px solid gold;
    border-right: 3px solid yellow;
    border-radius: 25%;
  }
}
/*canvas*/
#canvasWrapperWrapper {
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  perspective: 100000px;
  overflow: hidden;
  height: 100vh;
}
#canvasWrapper {
  position: absolute;
  height: 100vh;
  width: 100%;
  top: 0;
  left: 0;
  background-color: black;
  transition: background-color 1s, border-radius 1s;
  border-radius: 0;
}
#mainCanvas {
  height: 100%;
  width: 100%;
  top: 0;
  left: 0;
}
/*otherMain*/
#nextButton {
  user-select: none;
  position: fixed;
  border-radius: 50%;
  border: 5px ridge orange;
  cursor: pointer;
  right: 1%;
  bottom: 15%;
}
#prevButton {
  user-select: none;
  position: fixed;
  border-radius: 50%;
  border: 5px ridge orange;
  cursor: pointer;
  left: 1%;
  bottom: 15%;
}
.continueButtons {
  display: inline-block;
  padding: 3px;
  margin: 5px;
  cursor: pointer;
  user-select: none;
  background-color: lightBlue;
  border-radius: 25%;
  color: black;
}
.inlineContinueButtons {
  padding: 1px;
  padding-left: 3px;
  padding-right: 3px;
  margin-left: 3px;
  margin-right: 3px;
  cursor: pointer;
  user-select: none;
  background-color: lightBlue;
  border-radius: 25%;
  color: black;
  border-right: 4px solid orange;
  border-left: 4px solid orange;
  white-space: nowrap;
}
.externalNewWindowLinks {
  white-space: nowrap;
}
.externalNewWindowLinks::AFTER {
  content: ' \21ef';
  display: inline-block;
  transform: translate(0px, -3px) rotate(45deg);
  margin-left: 3px;
  margin-right: 3px;
}
/*UI*/
main {
  padding-top: 5.8em;
  padding-bottom: 5.5em;
}
.header {
  position: sticky;
  height: 0;
  top: 0;
  z-index: 10;
}
.header > .prettyMargin {
  height: 0;
}
.header svg {
  display: block;
  position: relative;
}
.UIbuttonWrappers {
  width: 48%;
  height: 0;
  display: inline-block;
  vertical-align: top;
}
#leftWrapper {
  text-align: left;
}
#logoWrapper,
#contactWrapper {
  height: 0;
}
.UIbuttonParent {
  cursor: pointer;
  position: relative;
}
#logo {
  display: inline-block;
  position: relative;
  font-size: 170%;
  font-style: italic;
  padding: 12px;
  border-radius: 50%;
  border-right: 3px ridge orange;
  border-bottom: 3px ridge orange;
  margin: 4px;
  background-color: rgba(0, 0, 0, 0.85);
  color: white;
}
#contactButton {
  position: relative;
  left: 110px;
  top: -12px;
}
#contactButton > div {
  padding: 5px;
  background-color: orange;
  border-radius: 50%;
}
#rightWrapper {
  text-align: right;
  z-index: 12;
  position: relative;
}
#musicControl {
  margin: 4px;
  padding: 12px;
  background-color: rgba(0, 0, 0, 0.85);
  border-left: 4px ridge orange;
  border-bottom: 4px ridge orange;
  position: relative;
  right: 24px;
  border-radius: 50%;
}
#gControl {
  margin: 4px;
  padding: 8px;
  background-color: orange;
  border-radius: 50%;
  position: relative;
  top: -21px;
  right: -5px;
}
.controlButtons {
  display: inline-block;
  cursor: pointer;
  user-select: none;
}
body {
  transition: color 1s, background-color 1s;
}
.activeView-Home {
  color: white;
}
.activeView-Home #canvasWrapper,
.activeView-Home {
  background-color: black;
}
.activeView-Music,
.activeView-Software,
.activeView-Math {
  color: black;
}
.activeView-Music #canvasWrapper,
.activeView-Software #canvasWrapper,
.activeView-Math #canvasWrapper {
  background-color: lightGreen;
}
.activeView-Music,
.activeView-Software,
.activeView-Math {
  background-color: seaShell;
}
.faceHeaders {
  margin-top: 2.4em;
}
.activeView-Contact #canvasWrapper,
.activeView-Contact {
  background-color: #0B1026;
}
.activeView-Contact {
  color: white;
}
.activeView-Social-Media #canvasWrapper,
.activeView-Social-Media,
.activeView-Latest-News-Articles #canvasWrapper,
.activeView-Latest-News-Articles,
.activeView-Jammaday #canvasWrapper,
.activeView-Jammaday,
.activeView-Factoring #canvasWrapper,
.activeView-Factoring,
.activeView-Apps-and-Libraries #canvasWrapper,
.activeView-Apps-and-Libraries {
  background-color: #006994;
}
.activeView-Social-Media,
.activeView-Latest-News-Articles,
.activeView-Jammaday,
.activeView-Factoring,
.activeView-Apps-and-Libraries {
  color: white;
}
.activeView-Credits #canvasWrapper,
.activeView-Credits,
.activeView-Mochobo #canvasWrapper,
.activeView-Mochobo,
.activeView-Unbalanced-Algebra #canvasWrapper,
.activeView-Unbalanced-Algebra,
.activeView-Tech-Stack #canvasWrapper,
.activeView-Tech-Stack,
.activeView-Web-Apps-Actualized #canvasWrapper,
.activeView-Web-Apps-Actualized,
.activeView-My-Salvation-In-Christ #canvasWrapper,
.activeView-My-Salvation-In-Christ {
  background-color: skyBlue;
}
.activeView-Mochobo,
.activeView-Unbalanced-Algebra,
.activeView-Tech-Stack,
.activeView-Web-Apps-Actualized {
  color: black;
}
/*backButtonCss*/
.activeView-Home #appButton-back {
  opacity: 0;
  top: -50px;
}
/*mediaControls*/
.graphicsSlashes {
  display: none;
}
.disableGraphics #mainCanvas {
  display: none;
}
.disableGraphics .graphicsSlashes {
  display: initial;
}
.disableGraphics #canvasWrapper {
  border-radius: 0 !important;
  transform: none !important;
}
.audioSlashes {
  display: none;
}
.disableAudio.audioHasPlayed .audioSlashes {
  display: initial;
}
.menuFlag {
  display: flex;
  text-align: left;
  position: absolute;
  right: 50%;
  width: 0;
  transition: width 1s;
  top: 0;
  overflow: hidden;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}
.menuFlag div {
  text-align: center;
  background-color: yellow;
  display: inline-block;
  white-space: nowrap;
  color: black;
  padding: 4px;
  border: 2px solid blue;
  border-bottom-right-radius: 15px;
  border-top-left-radius: 15px;
  border-top-right-radius: 3px;
  border-bottom-left-radius: 3px;
}
#menuFlagOpen {
  width: 200px;
}
.whenAudioHasPlayed {
  display: none;
}
.audioIsPlaying .whenAudioHasPlayed {
  display: initial;
}
.audioIsPlaying .whenAudioHasNotPlayed {
  display: none;
}
.whenAudioLoading {
  display: none;
}
.audioLoading .whenAudioLoading {
  display: initial;
}
.audioLoading .whenAudioHasPlayed,
.audioLoading .whenAudioHasNotPlayed {
  display: none !important;
}
/*mediaControlMenu*/
#mediaMenuWrapper {
  position: fixed;
  overflow-y: scroll;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
  background-color: seashell;
  transition: height 1s;
  color: black;
}
#mediaMenuBacker {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
#mediaMenuClient {
  padding-top: 15vh;
  margin: 8px;
  position: relative;
  padding-bottom: 15vh;
}
#mediaMenuCloser {
  position: fixed;
  right: 5%;
  top: 3%;
  border-radius: 50%;
  padding: 5px;
  cursor: pointer;
  user-select: none;
  background-color: white;
  border: 3px ridge orange;
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
  opacity: 1;
  transition: opacity 1s;
  z-index: 1001;
}
#mediaMenuCloser::before {
  content: 'X';
  font-family: sans-serif;
}
/*audioStuff*/
.audioTrackWrapper {
  padding: 4px;
}
.audioManipulateButton::before {
  content: 'Play';
}
.audioIsPlaying .audioManipulateButton::before {
  content: 'Pause';
}
.audioPlayerButtons {
  margin: 4px;
}
#audioPlayerTrack {
  vertical-align: middle;
  display: inline-block;
  position: relative;
  height: 12px;
  border-radius: 6px;
  background-color: lightGrey;
  text-align: left;
  width: 70%;
  margin: 4px;
}
#audioPlayerTrack > div {
  height: 12px;
  width: 12px;
  position: relative;
  border-radius: 50%;
  background-color: blue;
  cursor: pointer;
}
/*graphicsStuff*/
#graphicsDescriptionCatcher {
  margin: 10px;
  border: 2px solid gold;
  background-color: lightBlue;
  padding: 8px;
  border-radius: 7px;
}
#graphicsDescriptionCatcher li {
  text-align: left;
  padding: 3px;
}
#graphicsDescriptionCatcher #interactivityLabel {
  text-align: left;
}
#interactivityWrapper {
  display: inline-block;
  max-width: 400px;
  border: 3px outset orange;
  padding: 10px;
}
/*wAnimation*/
@keyframes wAnimation {
  0%,
  100% {
    transform: translateX(0) rotate(0deg);
  }
  25% {
    transform: translateX(-4px) rotate(10deg);
  }
  50% {
    transform: translateX(0) rotate(0deg);
  }
  75% {
    transform: translateX(4px) rotate(-10deg);
  }
}
.audioIsPlaying #musicControl svg {
  animation: wAnimation 2s linear infinite;
}
.disableAudio #musicControl svg {
  animation: none !important;
}
/*spinAnimation*/
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.audioLoading #musicControl svg {
  animation: spin 0.5s linear infinite !important;
}
@keyframes spinX {
  0% {
    transform: rotateX(0deg);
  }
  100% {
    transform: rotateX(90deg);
  }
}
@keyframes spinXFull {
  0% {
    transform: rotateX(0deg);
  }
  100% {
    transform: rotateX(720deg);
  }
}
@keyframes spinZFull {
  0% {
    transform: rotateZ(0deg);
  }
  100% {
    transform: rotateZ(720deg);
  }
}
@keyframes coinSpin {
  0% {
    transform: rotateY(0deg);
  }
  40% {
    transform: rotateY(0deg);
  }
  50% {
    transform: rotateY(90deg);
  }
  75% {
    transform: rotateY(185deg);
  }
  92% {
    transform: rotateY(90deg);
  }
  100% {
    transform: rotateY(0deg);
  }
}
/*general*/
.leaveSpace {
  margin-top: 200px;
}
.leaveSpaceAfter {
  margin-bottom: 200px;
}
.softLabel,
.smallLabel {
  font-size: 130%;
  font-weight: bold;
  margin: 4px;
}
.shortHrs {
  width: 65%;
}
.coinImage {
  display: inline-block;
  overflow: hidden;
  border-radius: 50%;
  border: 4px solid gold;
  box-shadow: 0px 10px 5px #888888;
}
.coinImage img {
  display: block;
}
.coinSpin {
  animation: coinSpin 5s linear infinite;
}
.fastZImage {
  animation: spinZFull 2s 1;
}
.fastXImage {
  animation: spinXFull 2s 1;
}
.transformTransImg {
  transition: transform 0.75s;
}
.imgScaleIn {
  transform: scale(1);
}
.imgScaleOut {
  transform: scale(0);
}
.halfOpaImg {
  opacity: 0.5;
}
.basicImage {
  border: 4px double gold;
  border-radius: 10px;
  display: inline-block;
  overflow: hidden;
}
.basicImage img {
  display: block;
}
.concurrentSection {
  margin-top: 58px;
}
.subHeading {
  margin-top: 0;
}
.innerSubHeading {
  font-weight: bold;
  font-size: 70%;
}
.parHeading {
  margin-bottom: 0;
}
.tabbed {
  margin-left: 40px;
}
ul {
  text-align: left;
  font-size: 105%;
}
li {
  margin-top: 10px;
}
code {
  width: 100%;
  box-sizing: border-box;
  overflow-x: scroll;
  text-align: left;
  display: block;
  white-space: nowrap;
  padding: 15px;
  background-color: seashell;
  color: black;
  border-radius: 10px;
}
code > div {
  width: fit-content;
}
ul code {
  width: 96%;
  margin-top: 8px;
  margin-bottom: 8px;
}
.jumpAroundWrapper {
  padding-bottom: 15px;
}
figcaption {
  margin-top: 5px;
}
/*contact*/
#contactMeForm {
  background-color: darkSlateGray;
}
#contactMeForm a:link {
  color: #F7E4A6;
}
#contactMeForm a:visited {
  color: palegoldenrod;
}
footer a:visited {
  color: paleGoldenrod;
}
footer a:link {
  color: goldenrod;
}
/*textBackers*/
.fishTextBacker,
.cloudTextBacker,
.faceTextBacker,
.blackTextBacker {
  padding: 5px;
  border: 2px solid gold;
  border-radius: 15px;
}
.fishTextBacker a {
  color: azure;
}
.fishTextBacker a:visited {
  color: gold;
}
.fishTextBacker {
  background-color: rgba(0, 100, 0, 0.8);
}
.fishTextFixer {
  background-color: rgba(0, 100, 0, 0.8);
  display: inline-block;
  padding: 5px;
  border-radius: 10px;
  margin-top: 5px;
}
.blackTextBacker {
  /*background-color:rgba(0,0,20,0.3);*/
  border: none;
  color: seashell;
}
.blackTextJump .jumpAroundWrapper h2,
.blackTextJump .jumpAroundWrapper span {
  /*background-color:rgba(0,0,10,0.3);*/
  padding: 5px;
  border-radius: 15px;
  color: seashell;
}
.spaceTextJump .jumpAroundWrapper h2,
.spaceTextJump .jumpAroundWrapper span {
  color: seashell;
  display: block;
  background-color: rgba(10, 10, 10, 0.9);
  padding: 8px;
  border-radius: 20px;
  margin: 24px;
}
.cloudTextBacker {
  background-color: rgba(135, 206, 235, 0.5);
}
.cloudTextBacker .inlineContinueButtons {
  background-color: lightGreen;
}
.faceTextBacker {
  background-color: rgba(147, 250, 165, 0.8);
}
/*factoringSection*/
#factorSizeLimitLabel::AFTER {
  display: block;
  width: 100%;
  text-align: center;
  margin: 3px;
  box-sizing: border-box;
}
.factorSizeLimitRemoved::AFTER {
  display: block;
  color: red;
  border: 3px solid red;
  background-color: white;
  border-radius: 8px;
  padding: 4px;
  content: 'Warning: Disabling size limits and entering extremely large numbers can cause your browser to appear unresponsive.';
}
.factorSizeLimitActive::AFTER {
  display: block;
  content: 'The size limit limits the size of the integer that you can factor, so as to not hang up your browser. Disable at your own risk. The limit is 1 billion.';
}
#factoringResult {
  min-height: 5.5em;
  margin: 18px;
  display: block;
}
.factoringError {
  color: red;
  border: 3px solid red;
  background-color: white;
  border-radius: 8px;
  padding: 4px;
  display: inline-block;
  margin: 18px;
}
.factoringWaitText {
  font-family: 'Arial', sans-serif;
  font-size: 24px;
  color: #3498db;
  text-align: center;
  letter-spacing: 2px;
  word-spacing: 5px;
  text-transform: uppercase;
  animation: fadeInUp 1.5s ease-in-out;
}
.factorWaitTextSpinner {
  animation: spinX 1s infinite alternate;
  animation-delay: 1.5s;
}
#factorSubmit {
  margin: 7px;
}
.factoringList {
  text-align: left;
  font-size: 125%;
}
/*fadeUpAnimation*/
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
/*techStack*/
/*appsNLibraries*/
/*latestNewsArticles*/
#latestNewsWrapper .DynamicBlog-Card {
  border-radius: 25%;
  background-color: forestGreen;
}
#latestNewsWrapper::AFTER {
  content: '(Takes You to the News Blog)';
  display: block;
  margin-top: 3px;
}
/*credits*/
.creditsImage {
  display: inline-block;
  padding: 9px;
  border-bottom: 3px solid gold;
  margin-right: 3px;
  margin-left: 3px;
}
.creditsImage:last-child {
  border-bottom: none;
}
.littleCreditsSubs {
  padding: 6px;
  border-radius: 10px;
  background-color: seashell;
  margin: 3px;
  border: 1px solid blue;
}
/*anianiPatch*/
.perspectiveFixers {
  perspective: 100000px;
  position: relative;
  z-index: 1;
}
.perspectiveFixers picture {
  position: relative;
  z-index: 1;
}
/*accessibilitySettings*/
/*phoneNumber*/
#phone-number {
  color: black;
}
.ContactForm-CommunicatorEls {
  color: black;
}
/*socialLogos*/
.socialLogos {
  display: inline-block;
  vertical-align: middle;
  height: 50px;
  margin: 20px;
}
.socialLogos img {
  height: 100%;
  width: auto;
}
.contactForm {
  display: inline-block;
  margin-top: 10px;
  margin-bottom: 10px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  width: 100%;
  box-sizing: border-box;
  border: 3px solid orange;
}
.contactForm input,
.contactForm textarea,
.contactForm select {
  margin-bottom: 10px;
  padding: 10px;
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
.contactForm textarea {
  min-height: 25vh;
  height: 70px;
}
/* Style the submit button */
.contactFormSubmitButton {
  background-color: #007bff;
  border: none;
  border-radius: 4px;
  color: #fff;
  cursor: pointer;
  font-size: 16px;
  padding: 10px 20px;
  transition: background-color 0.3s ease;
  width: 100%;
}
.contactFormSubmitButton:hover {
  background-color: #0056b3;
}
/* Style labels for inputs */
.contactForm label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}
/* Create some space between form sections */
.contactForm-section {
  margin-bottom: 20px;
}
/* Apply different styling to specific inputs, like checkboxes or radio buttons */
.contactForm input[type="checkbox"],
.contactForm input[type="radio"] {
  margin-right: 5px;
}
.grecaptcha-badge {
  display: none !important;
}
.ContactForm-CommunicatorEls {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  box-sizing: border-box;
  padding: 8px;
  background-color: lightBlue;
  border-top-left-radius: 25px;
  border-top-right-radius: 25px;
  border: 2px outset orange;
  z-index: 50;
  color: black;
}
.ContactForm-CommunicatorEls:empty {
  display: none;
}
.ContactForm-Form-ExtraInfo {
  margin-bottom: 8px;
  margin-bottom: 16px;
  display: inline-block;
  position: relative;
  top: -5px;
}
/* Base button styles */
.RPC-ChallengeButton {
  display: inline-block;
  padding: 10px 20px;
  /* Adjust padding to control button size */
  border: none;
  border-radius: 5px;
  /* Rounded corners */
  background-color: #f5f5f5;
  /* Light gray background color */
  color: #333;
  /* Text color */
  font-size: 16px;
  /* Adjust font size */
  font-weight: bold;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.1s;
  margin: 8px;
  border: 2px solid gold;
}
/* Hover styles */
.RPC-ChallengeButton:hover {
  background-color: #e0e0e0;
  /* Slightly darker background on hover */
  transform: scale(1.05);
  /* Slight scale-up effect on hover */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  /* Box shadow for depth */
}
/* Optional: Focus styles (for keyboard navigation) */
.RPC-ChallengeButton:focus {
  outline: none;
  /* Remove default focus outline */
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
  /* Add a focus outline */
}
/* Optional: Active styles (when button is clicked) */
.RPC-ChallengeButton:active {
  transform: scale(0.95);
  /* Slight scale-down effect when clicked */
}
/* Apply styles to the entire contact info container */
.contact-info {
  background-color: #f5f5f5;
  /* Light gray background color */
  padding: 20px;
  /* Add padding for spacing */
  border-radius: 10px;
  /* Rounded corners */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  /* Box shadow for depth */
  max-width: 400px;
  /* Limit the width of the container */
  margin: 0 auto;
  /* Center the container horizontally */
}
/* Style the phone number and email paragraphs */
.contact-info p {
  margin: 10px 0;
  /* Add margin for vertical spacing */
}
/* Style the strong tags (e.g., "Phone Number:" and "Email:") */
.contact-info strong {
  color: #333;
  /* Darken the strong text */
  font-weight: bold;
}
/* Style the buttons */
.contact-info button {
  background-color: #007bff;
  /* Blue button background color */
  color: #fff;
  /* White text color */
  border: none;
  /* Remove border */
  padding: 5px 10px;
  /* Add padding for button size */
  margin-right: 10px;
  /* Add spacing between buttons */
  border-radius: 5px;
  /* Rounded corners */
  cursor: pointer;
  /* Change cursor on hover */
  transition: background-color 0.3s;
  /* Smooth color transition on hover */
}
.contact-info button:hover {
  background-color: #0056b3;
  /* Darker blue on hover */
}
/* Style the links */
.contact-info a {
  text-decoration: none;
  /* Remove underline from links */
  color: #007bff;
  /* Blue link color */
  margin-right: 10px;
  /* Add spacing between links */
}
.contact-info a:hover {
  text-decoration: underline;
  /* Underline links on hover */
}
</style>




</head>
<body class="activeView-Latest-News-Articles">
<div id="canvasWrapperWrapper"><div id="canvasWrapper"><canvas id="mainCanvas"></canvas></div></div>
<div id="docuAniWrapper" class="aniRest1">
<header></header>
<div class="header"><div class="prettyMargin">
<div id="leftWrapper" class="UIbuttonWrappers">

<a class="invisiAnchors" href="/." title="Home" onclick="VCR.main.EventCHANGE(event, 'Home');"><div id="logo">GregGoad.net</div></a><br>
<a class="invisiAnchors" href="/contact" title="Contact" aria-label="Contact" onclick="VCR.main.EventCHANGE(event,'Contact'); " id="contactButton">
<div class="controlButtons">
<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="50" height="25">
<g>
        <rect x="0" y="0" width="49" height="24" rx="3" stroke="black" fill="seashell"></rect>
        <path d="M 2 0 L 24.5 12 L 47 0" stroke="black" fill="none"></path>
</g>
</svg>
</div>
</a>
<a href="/" class="invisiAnchors aria-label=" back to home title="Back to Home" onclick="VCR.main.EventCHANGE(event,APPBUTTONDATA['back'][VCR.main.GET_viewName()].name);"><div id="appButton-back" class="appButtons"><span id="appButton-back-content0" class="appButton-contents"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="28" height="25"> <g> 	<path id="path" d="M 24 24 C 26 15 21 12 11 14 L 10 18 L 1 9  L 10 1 L 11 6 C 23 5 31 12 24 24" stroke="black" fill="black" stroke-width="2"></path></g></svg></span></div></a>

</div>
<div id="rightWrapper" class="UIbuttonWrappers">
<div title="Mute Audio" aria-label="Mute Audio" id="musicControl" tabindex="0" onkeydown="AccKeydown(event, this, 'click');" class="controlButtons" role="button" onmouseover="OpenMenuFlag(this)" onmouseout="CloseMenuFlagEv(this);" onclick="AudioButtonClickEv(this); if(event.pointerType !== 'mouse'){OpenMenuFlag(this,true);}">


<div class="menuFlag"><div id="audioMenuFlag" class="menuFlagClient" tabindex="0" onkeydown="event.cancelBubble=true;AccKeydown(event, this, 'click');" role="button" title="Full Music Menu" aria-label="Open Music Menu" onclick="event.cancelBubble=true;VCR.menus.CHANGE('audio');if(!this.parentNode.parentNode.DATA_justPlayed &amp;&amp; event.pointerType !== 'mouse'){this.parentNode.parentNode.dispatchEvent(new Event('click'));}">Click Here For<br>Full Audio Menu</div></div>
<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="25" height="25">
<g>
	<path d="M 11 18 L 11 2 L 22 4 L 22 20" stroke="white" fill="none" stroke-width="2" class="whenAudioHasPlayed"></path>
	<ellipse cx="7" cy="18" rx="4" ry="2" fill="white" class="whenAudioHasPlayed"></ellipse>
	<ellipse cx="19" cy="20" rx="4" ry="2" fill="white" class="whenAudioHasPlayed"></ellipse>
         <path d="M 5 1 L 5 23 L 20 12" fill="white" class="whenAudioHasNotPlayed"></path>
	<path d="M 0 25 L 25 0" fill="none" stroke="red" stroke-width="2" class="audioSlashes"></path>
	<path d="M 0 0 L 25 25" fill="none" stroke="red" stroke-width="2" class="audioSlashes"></path>
        <path d="M12.5 1.04l2.12 6.48h6.76l-5.48 3.98 2.12 6.48-5.48-3.98-5.48 3.98 2.12-6.48-5.48-3.98h6.76z" class="whenAudioLoading" fill="white"></path>
</g>
</svg>
</div>


<br>
<div id="gControl" class="controlButtons" title="Disable Graphics" role="button" tabindex="0" onkeydown="AccKeydown(event, this,'click')" aria-label="Disable Graphics" onmouseover="OpenMenuFlag(this)" onmouseout="CloseMenuFlagEv(this)" onclick="ToggleGraphics();if(event.pointerType !== 'mouse'){OpenMenuFlag(this, true);}">

<div class="menuFlag"><div id="graphicsMenuFlag" class="menuFlagClient" role="button" title="Full Graphics Menu" tabindex="0" aria-label="Open Graphics Menu" onkeydown="event.cancelBubble=true;AccKeydown(event, this,'click')" onclick="event.cancelBubble=true;VCR.menus.CHANGE('graphics');if(event.pointerType !== 'mouse'){this.parentNode.parentNode.dispatchEvent(new Event('click'));}">Click Here For<br>Full Graphics Menu</div></div>
<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="26" height="24">
<g>
	<path id="path" d="M 1 12 C 6 23 20 24 24 12 C 21 4 10 4 1 12 " stroke="black" fill="white" stroke-width="2" stroke-linecap="round"></path>
	<circle cx="12" cy="12" r="5" fill="tan"></circle>
	<circle cx="12" cy="12" r="2.5" fill="black"></circle>
	<path d="M 0 25 L 25 0" fill="none" stroke="red" stroke-width="2" class="graphicsSlashes"></path>
	<path d="M 0 0 L 25 25" fill="none" stroke="red" stroke-width="2" class="graphicsSlashes"></path>
</g>
</svg>


</div>
</div>
</div></div>



<main><div class="prettyMargin"><div class="prettyMarginInner"><div id="contentTarget1"><h1 class="fishTextBacker">Recent News</h1>
<figure class="perspectiveFixers">
<div class="coinImage coinSpin" onclick="FastXSpin(this); " role="button" tabindex="0" onkeydown="AccKeydown(event, this);">
<picture><source srcset="/media/images/A-Man-and-His-Paper/512x512.png" media="(min-width:640px)" type="image/png" width="512" height="512"></source>
<source srcset="/media/images/A-Man-and-His-Paper/256x256.png 1x, /media/images/A-Man-and-His-Paper/512x512.png 2x" media="(min-width:320px)" type="image/png" width="256" height="256"></source>
<source srcset="/media/images/A-Man-and-His-Paper/128x128.png 1x, /media/images/A-Man-and-His-Paper/256x256.png 2x" media="(min-width:160px)" type="image/png" width="128" height="128"></source>
<source srcset="/media/images/A-Man-and-His-Paper/64x64.png 1x, /media/images/A-Man-and-His-Paper/128x128.png 2x" media="(min-width:80px)" type="image/png" width="64" height="64"></source>
<source srcset="/media/images/A-Man-and-His-Paper/32x32.png 1x, /media/images/A-Man-and-His-Paper/64x64.png 2x" media="(min-width:1px)" type="image/png" width="32" height="32"></source>
<img src="/media/images/A-Man-and-His-Paper/source.png" alt="A man in a Gatsby hat reading the newspaper at the kitchen table" width="1024" height="1024"></picture>
</div>
<figcaption>Serious People read Serious News
</figcaption>
</figure>
<div class="fishTextBacker">

			<div id="latestNewsWrapper"><?php require_once("$_SERVER[DOCUMENT_ROOT]/../WAA_siteGen_demoSecure/dynamicSectionDefinitions.php");
				require_once("$_SERVER[DOCUMENT_ROOT]/../php_library/htmlRenderers.php");
				
				$dat=$DynamicSectionFunctions['blog-news']['dataCalculator']($DynamicSectionFunctions['blog-news']['argumentCalculator']());
				
				echo HTML_elementOb(
				    ['tag'=>'div','properties'=>[], 'children'=>array_filter(
				        array_merge([
				            [
				                'tag'=>'div',
				                'properties'=>['class'=>'DynamicBlog-Header'], 
				                'children'=>array_filter(['Latest News Articles'])
				            ]],
				            array_map(function($eac) use ($dat ){
				                return [
				                    'tag'=>'a',
				                    'properties'=>['class'=>'invisiAnchors','target'=>'dynamicBlogReader','href'=>'/news/'.$eac["slug"].''],
				                    'children'=>array_filter([
				                        [
				                            'tag'=>'div',
				                            'properties'=>['class'=>'DynamicBlog-Card'], 
				                            'children'=>array_filter([
				                                [
				                                    'tag'=>'div',
				                                    'properties'=>[], 
				                                    'children'=>array_filter([$eac["title"]])
				                                ]
				                            ])
				                        ]
				                    ])
				                ];
				            }, $dat["articles"]))
				        
				    )]
				).'<script>DYNAMICSECTIONDATA[\'blog-news\'].data='.json_encode($dat).';</script>';
			?></div>
			
</div>

<div class="leaveSpace fishTextBacker">
<div class="jumpAroundWrapper"><h2>Jump Around the Site</h2> <div> <a class="invisiAnchors" href="/music" onclick="VCR.main.EventCHANGE(event, 'Music');"><div class="continueButtons"> Music </div></a><a class="invisiAnchors" href="/math" onclick="VCR.main.EventCHANGE(event, 'Math');"><div class="continueButtons"> Math </div></a><a class="invisiAnchors" href="/software" onclick="VCR.main.EventCHANGE(event, 'Software');"><div class="continueButtons"> Software </div></a> <br> <span>(These buttons will take you to new sections)</span> </div></div>
</div></div><div id="contentTarget2"></div></div></div></main>
<footer><div class="prettyMargin">
<div class="prettyMarginInner">
<div class="footerNav"><div><a onclick="VCR.main.EventCHANGE(event,'Home');" href="/">Home</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Music');" href="/music/">Music</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Software');" href="/software/">Software</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Math');" href="/math/">Math</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Jammaday');" href="/jammaday/">Jammaday</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Mochobo');" href="/mochobo/">Mochobo</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Factoring');" href="/factoring/">Factoring</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Unbalanced Algebra');" href="/unbalanced-algebra/">Unbalanced Algebra</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Tech Stack');" href="/tech-stack/">Tech Stack</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Apps and Libraries');" href="/apps-and-libraries/">Apps and Libraries</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Web Apps Actualized');" href="/waa/">Web Apps Actualized</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Contact');" href="/contact/">Contact</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Credits');" href="/credits/">Credits</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Latest News Articles');" href="/latest-news/">Latest News Articles</a></div><div><a onclick="VCR.main.EventCHANGE(event,'Social Media');" href="/social-media">Social Media</a></div><div><a onclick="VCR.main.EventCHANGE(event,'My Salvation In Christ');" href="/my-salvation-in-christ">My Salvation In Christ</a></div><div><a href="/news">News</a></div><div><a href="/privacy-policy.html">Privacy Policy</a></div></div>
<br>
<button onclick="_el.CancelEvent(event);CookieManager.Render();" class="CookieManager-LaunchButton">Open Cookie Manager</button>
<br><br>
<div id="copyWriteText">&copy; 2023 Greg Goad | Produced By <a href="https://webappsactualized.com" title="Website Producer">Web Apps Actualized</a></div>
</div>
<br>
<div>
View the
<a href="/credits" class="invisiAnchors" onclick="VCR.main.EventCHANGE(event,'Credits');">
<span class="inlineContinueButtons">
 Production Credits 
</span>
</a>
</div>
</div></footer></div>
</body>
</html>