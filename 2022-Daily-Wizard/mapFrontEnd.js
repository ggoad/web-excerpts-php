// All of the information is not present, this file is just
//		here as an example of the front end that's connected to the other map files.

BasicViewFunct('Location Mapper', function(a){
   

   var searchBoxInput;
   placesHidden=false;

   function TimeoutWait(arr){
      if(typeof google === "undefined"){
         setTimeout(function(){TimeoutWait(arr);},1000);
      }else{
         MapsWrapper.AddWaypointArr(arr);
      }
   }
   function GetWaypoints(){
      var fd=new FormData();
      fd.append('start', startDateInp.value);
      fd.append('end', endDateInp.value);
      // ( file, config, responseType, responseSuccess, captureMessage, btn, frm, failFunction)
      SpecialFetch("getMapperWaypoints.php",{method:"POST", body:fd},'json',function(jsn){
         TimeoutWait(jsn.data);
      }, "Getting Waypoints");
   }
   function ToggleViewablePlaces(btn){
      if(placesHidden){
         placesHidden=false;
         MapsWrapper.ShowSavedPlaces();
         btn.innerHTML="Hide Places";
      }else{
         placesHidden=true;
         MapsWrapper.HideSavedPlaces();
         btn.innerHTML="Show Places";
      }
   }
   function ToggleViewableWaypoints(btn){
       if(waypointsHidden){
          waypointsHidden=false;
          MapsWrapper.ShowWaypoints();
          btn.innerHTML="Hide Waypoints";
       }else{
          waypointsHidden=true;
          MapsWrapper.HideWaypoints();
          btn.innerHTML="Show Waypoints";
       }
   }
   
   var startDateInp, endDateInp;
   _el.APPEND(a.GET_target(true),[
      _el.CREATE('h3','','',{},['Start Mapping']),
      _el.CREATE('br'),_el.CREATE('br'),
      _el.CREATE('label','','',{},[
         "From: ",
         startDateInp=_el.CREATE('input','','',{type:'date', value:MysqlDate(new Date(history.state.dateContext)),onchange:function(){GetWaypoints();}})
       ]), " ", _el.CREATE('label','','',{},[
         "To: ",
         endDateInp=_el.CREATE('input', '','', {type:'date', value:MysqlDate(new Date(history.state.dateContext)),onchange:function(){GetWaypoints();}})
      ]),
      _el.CREATE('br'),_el.CREATE('br'),
      _el.CREATE('div','mapperMapBordreWrapper','',{},[
         _el.CREATE('button','','mapperButtons',{onclick:function(){
             ToggleViewablePlaces(this);
         }},["Hide Places"]),
         _el.CREATE('button','','mapperButtons',{onclick:function(){
             ToggleViewableWaypoints(this);
         }},["Hide Waypoints"]),
         _el.CREATE('button','mapsPlaceAdder','mapperButtons',{onclick:function(){MapsWrapper.TogglePlaceAdder(this);}},[""]),
         _el.CREATE('button','mapsWaypointAdder','mapperButtons',{onclick:function(){MapsWrapper.ToggleWaypointAdder(this);}},[""]),
         _el.CREATE('button','mapperClearSearch','mapperButtons',{onclick:function(){MapsWrapper.ClearSearchMarkers(); searchBoxInput.value='';}},["Clear Search"]),
         searchBoxInput=_el.CREATE('input','placeLookupInput'),
         _el.CREATE('div','mapperMapWrap','',{},[
            _el.CREATE('div','mapperMap'),
         ]),
         _el.CREATE('div','mapperFormCatcher'),
         _el.CREATE('h4','','',{},["Stop List"]),
         _el.CREATE('div','mapperStopList','',{},[MapsWrapper.WaypointButton()]),
         _el.CREATE('div','stopListFormCatcher'),
         _el.CREATE('button','locationMapperButton','',{
            onclick:function(){
              // ( file, config, responseType, responseSuccess, captureMessage, btn, frm, failFunction)
               var fd=new FormData();
               fd.append('start',startDateInp.value);
               fd.append('end',endDateInp.value);
               var buts=Array.from(document.querySelectorAll(".mapperWaypointStop"));
               buts=buts.filter(function(b){return b.DATA_inf;});
               buts=buts.map(function(b){
                  var inf={};
                  for(var mem in b.DATA_inf)
                  {
                     if(mem === 'place'){
                        inf.place={};
                        for(var mem2 in b.DATA_inf.place)
                        {
                           if(!mem2.match(/^DATA/)){
                              inf.place[mem2]=b.DATA_inf.place[mem2];
                           }
                        }
                        continue;
                     }
                     if(!mem.match(/^DATA/)){
                        inf[mem]=b.DATA_inf[mem];
                     }
                  }
                  return inf;
               });
               fd.append('stops', JSON.stringify(buts));
               SpecialFetch("saveMapperStops.php", {method:"POST", body:fd}, "json", function(jsn){
                  var target=document.getElementById('mapperStopList');
                  _el.EMPTY(target);
                  _el.APPEND(target, MapsWrapper.WaypointButton());
                  console.log("after save",jsn);
                  MapsWrapper.AddWaypointArr(jsn.data);
               },"Saving Stops", this);
            }
         },["Save"])
      ])
   ]);
   

   GetWaypoints();


   if(!locMapLoaded){ 
      locMapLoaded=true;
      _el.APPEND(document.head, _el.CREATE('script','','',{
         src:'https://maps.googleapis.com/maps/api/js?key=_redacted_&libraries=places&callback=INITLOCMAPPER'
      }));
   }else{
     INITLOCMAPPER();
   }


   
   

  
})

var locMapLoaded=false;
var mapsPlacesService=null;
var placesHidden=false;
var waypointsHidden=false;

var MapsWrapper={
	defaultMarker:'https://cdn.mapmarker.io/api/v1/pin?icon=fa-bullseye&size=40&hoffset=0&color=%23FFFFFF&background=%23FF7500&voffset=-1',
   globMap:null,
   marker:null,
   ClearMarkerArr:function(arr){
       this[arr].forEach(function(a){a.setMap(null);});
       this[arr]=[];
   },

   markers:[],
   waypoints:[],
   ShowWaypoints:function(){
      var t=this;
      this.waypoints.forEach(function(w){w.setMap(t.globMap);});
   },
   HideWaypoints:function(){
      this.waypoints.forEach(function(w){w.setMap(null);});
   },
   ClearWaypoints:function(){
      this.ClearMarkerArr('waypoints');
   },
   waypointId:0,
   AddWaypoint:function(inf){
       this.waypointId++;
       var t=this;
       if(!inf.place){
          inf={
             DATA_afterEl:inf.DATA_afterEl,
             DATA_mainEl:inf.DATA_mainEl,
             DATA_marker:inf.DATA_marker,
             arrivalTime:MysqlDate(new Date(history.state.dateContext))+' 07:00',
             departureTime:MysqlDate(new Date(history.state.dateContext))+' 07:30',
             commuteType:'driving',
             commuteVehicle:staticData.dayLog.personalVehicles.find(function(v){return v.name === "Charice";}),
             comment:'',
             mileagePool:{name:'Personal'},
             
             place:inf
          };
          inf.DATA_mainEl.DATA_inf=inf;
          if(inf.DATA_mainEl && inf.DATA_mainEl.previousSibling && inf.DATA_mainEl.previousSibling.previousSibling && inf.DATA_mainEl.previousSibling.previousSibling.DATA_inf){
             inf.arrivalTime=inf.departureTime=inf.DATA_mainEl.previousSibling.previousSibling.DATA_inf.departureTime;
          }
          var newNeeded=true;
       }
       inf.DATA_mainEl.DATA_inf=inf;

      var m=new google.maps.Marker({
		   icon:{url:'mywaypointicon.png',labelOrigin:{x:12,y:30}},
		   map:this.globMap,
                   title:inf.place.name,
                   optimized:false,
                   zIndex:500
                   
	   });
           m.DATA_waypointId=this.waypointId;
           inf.DATA_marker=inf.place.DATA_marker=m;
	   this.waypoints.push(m);
           var coor={lat:parseFloat(inf.place.location.lat), lng:parseFloat(inf.place.location.lng)};
	   m.setPosition(coor);
           
           m.addListener('click',function(event){
              if(document.querySelector('.routerActive')){
                 
              }else{
                 var el=_el.CREATE('div');
                 var keepArr=['commuteType','commuteTypeExt', 'commuteVehicle','commuteComment','mileagePool','arrivalTime','departureTime','comment'];
                 var rmf=RMFORM(el, RMF_typeMap(RMF_reorder(INPTYPES_inpLists.TBL_dayLog_stop, keepArr),{'commuteType':{type:'commuteTypes'},"commuteVehicle":{'type':'daylogVehicleList'},'mileagePool':{type:'daylogMileagePoolList'}}),
                 'editstopinfo', {
                   collProc:function(c){
                       keepArr.forEach(function(k){
                          inf[k]=c[k];
                       });
                       t.infowindow.close();
                   }
                 });
                 var contEl=_el.CREATE('div','','',{},[
                    _el.CREATE('button','','',{
                       onclick:function(){
                          // DATA_mainEl DATA_afterEl
                          if(inf.DATA_afterEl.id === 'ActivatedWaypointButton'){MoveId('ActivatedWaypointButton',inf.DATA_mainEl.previousSibling);}
                          _el.REMOVE(inf.DATA_mainEl); _el.REMOVE(inf.DATA_afterEl);
                          t.waypoints.splice(t.waypoints.findIndex(function(w){return w.DATA_waypointId === m.DATA_waypointId;}),1);
                          m.setMap(null);
                          t.infowindow.close();
                          console.log(m);
                       }
                    },["Remove"]),
                    _el.CREATE('br'),
                    _el.CREATE('h3','','',{},[inf.place.name]), el
                 ]);
                 rmf.SET(inf);
                 t.infowindow.close();
                 t.infowindow.setContent(contEl);
                 t.infowindow.setPosition(coor);
                 t.infowindow.open(t.globMap);
                 MoveId('selectedWaypointStop',inf.DATA_mainEl);
              }
           });
           
                 if(newNeeded){
                    google.maps.event.trigger(m, 'click');
                 }
   },
   AddWaypointArr:function(arr){
      var target=document.getElementById('mapperStopList');
      _el.EMPTY(target);
      _el.APPEND(target, this.WaypointButton());
      this.ClearWaypoints();
      var th=this;
      arr.forEach(function(a){th.WaypointStop(a.place,a);});
   },
   savedPlaces:[],
   HideSavedPlaces:function(){
      this.savedPlaces.forEach(function(a){a.setMap(null);});
   },
   ShowSavedPlaces:function(){var t=this; this.savedPlaces.forEach(function(a){a.setMap(t.globMap);});},
   ClearSavedPlaces:function(){
      this.ClearMarkerArr('savedPlaces');
   },
   AddSavedPlacesArr:function(arr){
      this.ClearSavedPlaces();
      var t=this;
      arr.forEach(function(a){t.AddSavedPlace(a);});
      if(placesHidden){this.HideSavedPlaces();}
   },
   AddSavedPlace:function(inf){
      var t=this;
      var m=new google.maps.Marker({
		   icon:{url:'myplaceicon.png',labelOrigin:{x:12,y:35}},
		   map:this.globMap,
                   title:inf.name,
                   label:{
                      text:inf.name,
                      color:'black',
                      fontSize:"125%",
                      className:'savedPlacesLabels',
                      backgroundColor:'seaShell'
                   }
	   });
	   this.savedPlaces.push(m);
           var coor={lat:parseFloat(inf.location.lat), lng:parseFloat(inf.location.lng)};
	   m.setPosition(coor);
           m.addListener('click',function(event){
              var el;
              if(document.querySelector('.mapperWaypointActive')){
                 t.WaypointStop(inf);
              }else if(el=document.querySelector('.mapperPlacePickerActive')){
                 el.FUN_selectPlace(inf);
              }else{
                 
                 t.infowindow.setContent(_el.CREATE('div','','',{},[
                    _el.CREATE('button','','',{},['Edit']),
                    _el.CREATE('button','','',{},['Delete'])
                 ]));
                 t.infowindow.setPosition(coor);
                 t.infowindow.open(t.globMap);
              }
           });
   },
   searchMarkers:[],
   ClearSearchMarkers:function(){
      this.ClearMarkerArr('searchMarkers');
   },
   AddSearchMarkerArr:function(arr){
	   this.ClearSearchMarkers();
	   var t=this;
	   var bounds=new google.maps.LatLngBounds();
	   arr.forEach(function(a){
		   a.map=t.globMap;
		   var p=a.place || {};
		   delete a.place;
		   var m;
		   t.searchMarkers.push(m=new google.maps.Marker(a));
		   if(p.formatted_address){
			   m.addListener('click',function(){
				console.log('fromSearchMarker', p);
                                if(document.querySelector('.mapperAdderActive')){
                                    MapsWrapper.AddAdderMarker(a.position);
                                    MapsWrapper.adderForm.SET({name:p.name, address:FormattedAddrToOb(p.formatted_address)});
                                }
			   });
		   }
		   if(p.geometry){
			   if(p.geometry.viewport){
				   bounds.union(p.geometry.viewport);
			   }else{
				   bounds.extend(p.geometry.location);
			   }
		   }else{
			   bounds.extend(a.position);
		   }
	   });
	   t.globMap.fitBounds(bounds);
	 //  t.globMap.setZoom(Math.min(t.globMap.getZoom(), 8));
   },
   adderMarker:null,
   adderIndex:0,
   AddAdderMarker:function(coor){
           var t=this;
           this.adderIndex++;
           this.RemoveAdderMarker();
          //(target, inps, name, config)
           var frm=this.adderForm=RMFORM(this.formCatcher, [
              {
                 name:'name',labelText:'Name',type:'singleLine'
              },
              {
                 name:'lat',labelText:'Lat',type:'singleLine'
              },
              {
                 name:'lng',labelText:'Long',type:'singleLine'
              },
              {
                 name:'address',labelText:'Address',type:'compound', class:'locAddressInp',inps:RMF_reorder(RMF_typeMap(INPTYPES_inpLists.TBL_world_addresses, {
                    isStreet:{type:'hidden', value:'1'},
                    country:{value:'USA'}
                 }),['line1','line2','city','state', 'zip', 'country','isStreet'])
              },
           ], 'adderForm', {
              collProc:function(c){
                 console.log(c);
                 var fd=new FormData();
                 fd.append('dat',JSON.stringify(c));
                 // ( file, config, responseType, responseSuccess, captureMessage, btn, frm, failFunction)
                 SpecialFetch('mapperAddPlace.php',{method:'POST', body:fd}, 'json',function(jsn){
                    t.AddSavedPlace(jsn.data);
                    t.infowindow.close();
                    t.RemoveAdderMarker();
                 },'AddingPlace');
              }
           });
           frm.SET({lat:GetCoorVal(coor.lat), lng:GetCoorVal(coor.lng)});
           var t=this;
	   var m=new google.maps.Marker({
		   icon:this.defaultMarker,
		   map:this.globMap,
                   draggable:true
	   });
	   this.adderMarker=(m);
	   m.setPosition(coor);
           m.addListener('click',function(){
              t.infowindow.setContent(_el.CREATE('div','','',{},[_el.CREATE('button','','',{onclick:function(){t.RemoveAdderMarker();t.infowindow.close();}},['Cancel'])]));
              t.infowindow.setPosition(coor);
              t.infowindow.open(t.globMap);
           });
           m.addListener('dragend',function(e){
               t.adderForm.SET({lat:GetCoorVal(e.latLng.lat), lng:GetCoorVal(e.latLng.lng)});
           });
           
	   return m;
  
   },
   RemoveAdderMarker:function(){
      
      if(this.adderMarker){
         this.adderMarker.setMap(null);
         this.adderMarker=null;
         
      }
      if(this.formCatcher){
        _el.EMPTY(this.formCatcher);
        this.adderForm=null;
      }
   },
   initMap:function(id){
      this.globMap=new google.maps.Map(document.getElementById(id), {
         center: { lat:36.304104, lng:-80.245853 },
         zoom: 12,
      });
      this.infowindow=new google.maps.InfoWindow();
      //
      this.seachBoxInput=document.getElementById('placeLookupInput');
     this.mapBorder=document.getElementById('mapperMapBordreWrapper');
     this.formCatcher=document.getElementById('mapperFormCatcher');
   },

   
    infowindow:null,
    infowindowContent:null,
    searchBoxInput:null, 
    mapBorder:null,
    placeAdderActive:false,
    formCatcher:null,
    adderForm:null,
    TogglePlaceAdder:function(b){
       this.mapBorder.classList.toggle('mapperAdderActive');
       this.RemoveAdderMarker();
    },
    ToggleWaypointAdder:function(btn){
       this.mapBorder.classList.toggle('mapperWaypointActive');
       if(document.querySelector('.mapperWaypointActive')){
          MoveId('ActivatedWaypointButton',Array.from(document.querySelectorAll('.mapperWaypointClicker')).pop());
       }else{
          ClearId('ActivatedWaypointButton');
       }
    },
    ActivateWaypointAdder:function(btn){
       this.mapBorder.classList.add('mapperWaypointActive');
       MoveId('ActivatedWaypointButton',btn);
    },

    WaypointButton:function(){
      return _el.CREATE('div','','mapperWaypointClicker',{
        onclick:function(){
           MapsWrapper.ActivateWaypointAdder(this);
        }
      },[])
   },
   WaypointStop:function(inf, realInf){
      var anchor=document.querySelector('#ActivatedWaypointButton');
      var nextSib=null;
      inf=_ob.CLONE(inf, -1);
      if(anchor){
         nextSib=anchor.nextSibling;
      }
      var newAnchor=null;
      var par=document.querySelector('#mapperStopList');
      par.insertBefore((realInf || inf).DATA_mainEl=_el.CREATE('div','','mapperWaypointStop',{
         onclick:function(){
            console.log(inf);
            MapsWrapper.globMap.setCenter((realInf || inf).DATA_marker.getPosition());
            google.maps.event.trigger((realInf || inf).DATA_marker, 'click');
         }
      },[
         inf.name
      ]), nextSib);
      par.insertBefore((realInf || inf).DATA_afterEl=newAnchor=MapsWrapper.WaypointButton(), nextSib);
      if(document.querySelector('.mapperWaypointActive')){
         MoveId('ActivatedWaypointButton', newAnchor);
      }
      
      this.AddWaypoint(realInf || inf);
   }
};
function INITLOCMAPPER(){
   function IconClickListener(event){
      console.log(event);
      if(("placeId" in event)){
         if(document.querySelector('.mapperAdderActive')){
            event.stop();
            console.log(event);
            console.log(event.latLng.lat(), event.latLng.lng());
            MapsWrapper.AddAdderMarker(event.latLng);
            var indSav=MapsWrapper.adderIndex;
            mapsPlacesService.getDetails({placeId:event.placeId}, function(place,status){
               if(status === "OK" && place && place.geometry && place.geometry.location){
                  //place.name, place.formatted_address
                  if(MapsWrapper.adderIndex === indSav){
                     MapsWrapper.adderForm.SET({name:place.name, address:FormattedAddrToOb(place.formatted_address)});
                  }
               }
            });
         }
         return;
      }
      if(document.querySelector('.mapperAdderActive')){
         MapsWrapper.AddAdderMarker(event.latLng);
         
      }
      //MapsWrapper.MakeMarker(event.latLng);
       
   }
   MapsWrapper.initMap('mapperMap');
   var map=MapsWrapper.globMap;
   var input=document.getElementById('placeLookupInput');
   if(!mapsPlacesService){
      mapsPlacesService=new google.maps.places.PlacesService(map);
   }
   
   var placeListTimeout;
   var mapperBoundsInd=0;
   VCR.main.REGISTER_changeANDrelease(function(){clearTimeout(placeListTimeout); mapperBoundsInd=0;});
   map.addListener('bounds_changed',function(){
           mapperBoundsInd++;
           var boundsIndSav=mapperBoundsInd;
           clearTimeout(placeListTimeout);
           placeListTimeout=setTimeout(function(){
              if(mapperBoundsInd !== boundsIndSav){return;}
              var fd= new FormData();
              var bound=map.getBounds();
              fd.append('ne', JSON.stringify(bound.getNorthEast().toJSON()));
              fd.append('sw', JSON.stringify(bound.getSouthWest().toJSON()));
              fetch("getPlacesByBounds.php",{method:"POST", body:fd}).then(function(resp){
                 if(!resp.ok){
                    throw new Error("Server Error: "+resp.status);
                 }
                 return resp.json();
              }).then(function(jsn){
                 if(boundsIndSav === mapperBoundsInd){
                    if(!jsn.success){
                       throw new Error("Error: "+jsn.message);
                    }
                    MapsWrapper.AddSavedPlacesArr(jsn.data);
                 }
              }).catch(function(e){
                 console.log('There was an error '+e.message);
              });
           },500);
	   searchBox.setBounds(map.getBounds());
   });
   
   var searchBox=new google.maps.places.SearchBox(input);
   map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   
   map.addListener('click', IconClickListener);
   
   searchBox.addListener('places_changed', function(){
	   var places=searchBox.getPlaces();
	   if(!places.length){return;}
	   var arr=[];
	   MapsWrapper.ClearSearchMarkers();
	   places.forEach(function(place){
		   if(!place.geometry || !place.geometry.location){
			   return; 
		   }
		   const icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25),
			  };
		   arr.push({
			   icon:icon,
			   title:place.name,
			   position:place.geometry.location,
			   place:place,
			   label:{
				   text:place.name,
				   className:'markerLabel'
			   }
		   });
	   });
	  console.log(arr.map(function(a){return a.place;}));
	   MapsWrapper.AddSearchMarkerArr(arr);
   });
}