var valtozokKi={};
var hanyadikSor={};

function alakit(index){
  ki="";
  let beker=document.getElementById("eredmeny").innerHTML;
  beker=beker.replaceAll('<span style="color:green;"> ⮜ </span>'," ")
  beker=beker.split("<br>");
  beker[index]=beker[index]+" <span style='color:green;'> &#x2B9C; </span>";
  for(k in beker){
    ki+=beker[k]+" <br>";
  }
  return ki;
}

function* myApp(index,minden) {

  for(m in minden){
    if(minden[m]["ifben"]==="IGEN"){
      kezd=minden[m]["kezdet"]-1;
      yield document.getElementById("eredmeny").innerHTML=alakit(kezd);
      igaze=false;
      
      for(i=0;i<minden[m]["feltetelek"].length;i++){
        yield document.getElementById("eredmeny").innerHTML=alakit(minden[m]["feltetelek"][i]['kezd']-1+kezd);
        k=minden[m]["feltetelek"][i]['kezd'];
        if(eval(minden[m]["feltetelek"][i]["feltetel"]) && !igaze ){
          sorok=minden[m]["feltetelek"][i]["mit"].split("\n");
            for(s in sorok){
              
              if(sorok[s] !== " "){
                console.log(sorok[s]);
              yield document.getElementById("eredmeny").innerHTML=alakit(k+kezd);  
              k++;            
              eval(sorok[s]);
              let out='';
              for (let [key, value] of Object.entries(valtozok)) {
                if(value===''){
                  out+=`${key}= null &#8195;`;
                }else{
                  out+=`${key}= ${value} &#8195;`;
                } 
              }
              document.getElementById("valtozok").innerHTML=out; 
            }
          }
          
        igaze=true;
      }
    }
    yield document.getElementById("eredmeny").innerHTML=alakit(minden[m]["hanyszor"]+kezd);
    }else{
    yield document.getElementById("eredmeny").innerHTML=alakit(minden[m]["kezdet"]);  
    for(i=0;i<minden[m]["hanyszor"];i++){
      for(j=0;j<minden[m]["soronkent"].length;j++){
        eval(minden[m]["soronkent"][j]);
        let out='';
        for (let [key, value] of Object.entries(valtozok)) {
          if(value===''){
            out+=`${key}= null &#8195;`;
          }else{
            out+=`${key}= ${value} &#8195;`;
          }
        }
        document.getElementById("valtozok").innerHTML=out; 
        yield document.getElementById("eredmeny").innerHTML=alakit(minden[m]["kezdet"]+(j+1)); 
    }
    
     yield document.getElementById("eredmeny").innerHTML=alakit(minden[m]["kezdet"]);  
  }
  yield  document.getElementById("eredmeny").innerHTML=alakit(minden[m]["kezdet"]+minden[m]["soronkent"].length+1);
  }
}
}


document.getElementById('futtat').addEventListener('click',function(e){
  osszes=[];
  for(k in valtozok){
  try
    {
      if(typeof(valtozok[k])==="string"){
      val=valtozok[k];       
      val=parseInt(val);
      if (!isNaN(val)){
        valtozok[k]=parseInt(valtozok[k]);
      } 
    }     
    }
    catch (err)
    {
        console.log(err);   
    }
  }
  
  javaScriptkod=document.getElementById('eredmeny').innerHTML;
  javaScriptkod=javaScriptkod.replaceAll("<br>",'\n');
  javaScriptkodSorok=javaScriptkod.split('\n');
  e.preventDefault();
  for(let i=0;i<javaScriptkodSorok.length;i++){
    
    if(javaScriptkodSorok[i].trim().split(' ')[0]==="while("){
      kezdet=i;
      whileCiklus="";
      do{
        whileCiklus+=javaScriptkodSorok[i].trim()+" \n";
        i++;
      }while(javaScriptkodSorok[i].trim()!=="}")
      minden=createWhileCiklus(whileCiklus); 
      minden["kezdet"]=kezdet;
      osszes.push(minden);
    
    }else if(javaScriptkodSorok[i].trim().split(' ')[0]==="for"){
      forciklus="";
      kezdet=i;
      do{ 
        forciklus+=javaScriptkodSorok[i].trim()+" \n";
        i++;
      }while(javaScriptkodSorok[i].trim()!=="}");
      forciklus+=javaScriptkodSorok[i].trim()+" \n";
       minden=createForciklus(forciklus);
       minden["kezdet"]=kezdet;
       osszes.push(minden);
       
     }else if(javaScriptkodSorok[i].trim().split(' ')[0]==="if"){
      elagazas="";
      megyMeg=true;
      kezdet=i;
      while(megyMeg){
        elagazas+=javaScriptkodSorok[i].trim()+" \n";
        i++;
        a=i;
        b=a
        if(++b===javaScriptkodSorok.length ||(javaScriptkodSorok[a].trim().split(' ')[0]==="}"&&javaScriptkodSorok[++a].trim().split(' ')[0]!=="else")){
           megyMeg=false;
           elagazas+=javaScriptkodSorok[i].trim()+" \n";
         }
     }
     minden=createIfElse(elagazas);
     minden["kezdet"]=kezdet;
     osszes.push(minden);
  }
}
const iterator = myApp(0,osszes);

     setInterval(function(){
       iterator.next();
       }, 1000);

});

   
function createForciklus(line){
 
  minden={};
  lines=line.replaceAll("&lt;","<")
  lines=lines.replaceAll("&gt;",">")
  lines=line.replaceAll("- ="," -= ");
  lines=line.replaceAll("+ ="," += ");
  lines=lines.replaceAll("++"," ++ ");
  lines=lines.replaceAll("--"," --");
  
  lines=lines.split("\n")
  firstLine=lines[0].split(" ");
  hanyszor=firstLine[4]-firstLine[2];
  bentivaltozok={};
  belseje="";
   for(lin in lines){
    szavak=lines[lin].split(" ");
    if(szavak[0].trim()==="for" || szavak[0].trim()==="}"){

    }else{
      belseje+=lines[lin]+ "\n";
    }
   }

   soronkent=[]

   belsejeSoronkent=belseje.split("\n");
   for(belsejeSor in belsejeSoronkent){
   egybe=""
   bel=belsejeSoronkent[belsejeSor].split(" ");
   for(b in bel){
     for(a in valtozok){   
     if(bel[b].trim()===a){   
       bel[b]="valtozok[\""+a+"\"]"; 
     } 
   }
   egybe+=bel[b];
   }
   if(egybe!==""){
   soronkent.push(egybe);
   } 
 }
  minden["soronkent"]=soronkent;
  minden["hanyszor"]=hanyszor;
  return minden;
  
}
function createWhileCiklus(line){
  minden={};
  belseje="";
  bentivaltozok={};
  let feltetel="";
  lines=line.replaceAll("+ ="," += ");
  lines=lines.replaceAll("++"," ++ ");
  lines=lines.replaceAll("--"," --");
  lines=lines.replaceAll("&lt;","<");
  lines=lines.replaceAll("&gt;",">")
  lines=lines.replaceAll("&amp;","&")
  let hanyszor=0;

  lines=lines.split("\n")
  lines[0]=lines[0].replaceAll("=","===");
  firstLine=lines[0].split(" ");
  
  i=0;
  while(firstLine[i]!==")"){
    if(firstLine[i]==="while("){

    }else{
      feltetel+=" "+firstLine[i];
    }
    
    i++;
    
  }
  for(lin in lines){
    szavak=lines[lin].split(" ");
    
    for(s in szavak){
      if(szavak[s].trim()==="while(" || szavak[s]==="{" || szavak[s]==="}" || szavak[s]===""){}
         else{
             for(a in valtozok){
              
               if(szavak[s].trim()===a){
                 eval("var "+a +"="+valtozok[a]);
                 bentivaltozok[a]=eval(valtozok[a]);
                 
               }
             }
            }
            
    }
    if(szavak[0].trim()==="while("){
    }else{
         belseje+=lines[lin]+"\n"; 
}
  }
  
  while(eval(feltetel)){
    eval(belseje);
    hanyszor++;
    if(hanyszor>1000){break;}
    
  }
  
  soronkent=[]
  belse=belseje.split("\n");
  for(bels in belse){
  egybe=""
  bel=belse[bels].split(" ");
  for(b in bel){
    for(a in valtozok){
    if(bel[b].trim()===a){
      bel[b]="valtozok[\""+a+"\"]";
     
    }
    
  }
  egybe+=bel[b];
  }
  if(egybe!==""){
  soronkent.push(egybe);
  } 
}
  minden["soronkent"]=soronkent;
  minden["hanyszor"]=hanyszor;
  minden["feltetel"]=feltetel;
  return minden;

}

function createIfElse(line){
  minden={};
  line=line.replaceAll("==="," === ");
  line=line.replaceAll("&lt;"," < ");
  line=line.replaceAll("&gt;"," > ");
  feltetelek=[];
  egesz="";
  lines=line.split("\n")
  sorokSzama=0;
  for(lin in lines){
    belseje="";
    szavak=lines[lin].split(" ");
      for(s in szavak){  
          for(a in valtozok){
            if(szavak[s].trim()===a){
              szavak[s]="valtozok[\""+a+"\"]";
            }
          }
          belseje+=szavak[s]+" ";
      }
      if(belseje!==" "){
        sorokSzama++;
        egesz+=belseje+"\n";
        } 
    }
    
    sorok={};
    mit="";
    osszesSor=[];
    egeszSzetszedve=egesz.split("\n");
    for(i=0;i<egeszSzetszedve.length;i++){
      sor=egeszSzetszedve[i].split(" ");
      if(sor[0].trim()==="if" ){
        egeszSzetszedve[i]=egeszSzetszedve[i].replaceAll("if (","");
        egeszSzetszedve[i]=egeszSzetszedve[i].replaceAll(")","");
        egeszSzetszedve[i]=egeszSzetszedve[i].replaceAll("{","");
        sorok["feltetel"]=egeszSzetszedve[i];
        i++;
        sor=egeszSzetszedve[i].split(" ");
        while(sor[0]!=="}"){
          mit+=egeszSzetszedve[i]+" \n ";
          i++;
          sor=egeszSzetszedve[i].split(" ");
        }
        sorok["mit"]=mit;
        sorok["kezd"]=i;
        osszesSor.push(sorok)
        mit="";
        sorok={};
      

      }
      else if(sor[0].trim()=="else" && sor[1].trim()==="if"){
       
        egeszSzetszedve[i]=egeszSzetszedve[i].replaceAll("else if (","");
        egeszSzetszedve[i]=egeszSzetszedve[i].replaceAll(")","");
        egeszSzetszedve[i]=egeszSzetszedve[i].replaceAll("{","");
        sorok["feltetel"]=egeszSzetszedve[i];
        
        i++;
        sor=egeszSzetszedve[i].split(" ");
        while(sor[0]!=="}"){
          mit+=egeszSzetszedve[i]+" \n ";
          i++;
          sor=egeszSzetszedve[i].split(" ");
        }
        sorok["mit"]=mit;
        sorok["kezd"]=i;
        osszesSor.push(sorok)
        
        mit="";
        sorok={};
        
      }else if(sor[0]==="else"){
        sorok["feltetel"]="true";
        i++;
        sor=egeszSzetszedve[i].split(" ");
        while(sor[0]!=="}"){
          mit+=egeszSzetszedve[i]+" \n ";
          i++;
          sor=egeszSzetszedve[i].split(" ");
        }
        sorok["mit"]=mit;
        sorok["kezd"]=i;
        osszesSor.push(sorok)
      }
    }
    
    minden["ifben"]="IGEN";
     minden["hanyszor"]=sorokSzama;
     minden["feltetelek"]=osszesSor;
     
     return minden;
}
