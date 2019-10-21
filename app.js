
let forCiklusbanVan=false;
let ifbenVan=false;
let valtozok={};
let valtozokBeker={};

document.getElementById('futtat').addEventListener('click',function(e){
  javaScriptkod=document.getElementById('eredmeny').innerHTML;
  javaScriptkod=javaScriptkod.replaceAll("<br>",'\n');
  javaScriptkodSorok=javaScriptkod.split('\n');
  
 
  for(let i=0;i<javaScriptkodSorok.length;i++){
    if(javaScriptkodSorok[i].trim().split(' ')[0]==="while("){
      console.log(javaScriptkodSorok[i].trim().split(' '));
      whileCiklus="";
      do{
       // 
        whileCiklus+=javaScriptkodSorok[i].trim()+" \n";
        i++;
        
      }while(javaScriptkodSorok[i].trim()!=="}")
      createWhileCiklus(whileCiklus);
      
    }else if(javaScriptkodSorok[i].trim().split(' ')[0]==="if"){
      elagazas="";
      megyMeg=true;
      utolso=false;
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
      //console.log(elagazas);
      createIfElse(elagazas);
    }else if(javaScriptkodSorok[i].trim().split(' ')[0]==="for"){
      forciklus="";
      do{ 
        forciklus+=javaScriptkodSorok[i].trim()+" \n";
        i++;
      }while(javaScriptkodSorok[i].trim()!=="}")
      forciklus+="wait(1000);\n";
      forciklus+=javaScriptkodSorok[i].trim()+" \n";
      createForciklus(forciklus);
    }
    
  }
  e.preventDefault();
});

document.getElementById('ok').addEventListener('click',function(e){

  document.getElementById("eredmeny").innerHTML='';
  document.getElementById("valtozokBe").innerHTML='';
  var rows = document.querySelector('textarea').value.split("\n").length;
  for(b=0;b<rows;b++){
    let text=document.querySelector(".textArea").value.split("\n")[b]
    search(text);
  }

  e.preventDefault();
});


function createForciklus(line){
  line=line.replaceAll("&lt;","<")
  line=line.replaceAll("&gt;",">")
  lines=line.split("\n")
  bentivaltozok={};
  for(lin in lines){
    szavak=lines[lin].split(" ");
      for(s in szavak){
          for(q in szavak[s]){
            for(a in valtozok){
              if(szavak[s][q]===a){
                eval("var "+a +"="+valtozok[a]);
                bentivaltozok[a]=eval(valtozok[a]);
                break; 
          }
        }
      }
    }
  }
  console.log(line+"   forba");
  eval(line);
  for(k in line){
    for(a in bentivaltozok){
      if(line[k]===a){
        bentivaltozok[line[k]]=eval(line[k]);
        valtozok[a]=bentivaltozok[a];
        valtozokErtekKiir(valtozok); 
      }
    }
  }    
}
function createWhileCiklus(line){
 
  belseje="";
  bentivaltozok={};
  lines=line.replaceAll(" = ","===")
  lines=lines.replaceAll("&lt;","<")
  lines=lines.replaceAll("&gt;",">")
  lines=lines.split("\n")
  let feltetel="";
  for(lin in lines){
    szavak=lines[lin].split(" ");
    if(szavak[0].trim()==="while("){
      feltetel=szavak[1];
      for(s in szavak){
        if(szavak[s].trim()==="while(" || szavak[s]==="{"){}
        else{
          for(q in szavak[s]){
            for(a in valtozok){
              if(szavak[s][q]===a){
                eval("var "+a +"="+valtozok[a]);
                bentivaltozok[a]=eval(valtozok[a]);
                break;
              }
            }
          }
        }
      }
    }else{
      for(s in szavak){
        belseje+=szavak[s];
      }
    }
  }
   while(eval(feltetel)){
    eval(belseje);
    wait(1000);
    for(k in belseje){
      for(a in bentivaltozok){
        if(belseje[k]===a){
          bentivaltozok[belseje[k]]=eval(belseje[k]);
          valtozok[a]=bentivaltozok[a];
          valtozokErtekKiir(valtozok); 
        }
      }
    }    
  }
}

function createIfElse(line){
  belseje="";
  let bentivaltozok={};
  lines=line.split("\n")
  feltetel="";
  for(lin in lines){
    szavak=lines[lin].split(" ");
      for(s in szavak){
        if(s!=="if"|| s!=="else"|| s!=="{"||s!=="}"){
          for(q in szavak[s]){
            for(a in valtozok){
              if(szavak[s][q]===a){
                eval("var "+a +"="+valtozok[a]);
                bentivaltozok[a]=eval(valtozok[a]);
                
                break;
            }
          }
        }
      }
    
    }
    if(lines[lin].includes("if")|| lines[lin].includes("else")){
      feltetel+=lines[lin]+"\n";
      feltetel+=("wait(3000);\n");
      //feltetel+=`console.log("${lines[lin]}");\n`
    }
    else{feltetel+=lines[lin]+"\n";}
    
  }
  
  
  eval(feltetel);
  for(k in feltetel){
    for(a in bentivaltozok){
      if(feltetel[k]===a){
        bentivaltozok[feltetel[k]]=eval(feltetel[k]);
        valtozok[a]=bentivaltozok[a];
        valtozokErtekKiir(valtozok); 
      }
    }
  }    


}
function wait(ms){
  var start = new Date().getTime();
  var end = start;
  while(end < start + ms) {
    end = new Date().getTime();
  }
}

function search(line){
  
  let sor='';

  if(line.trim()==='elágazás vége'){
    newlineOut("}");
    ifbenVan=false;
  }
  else if(line.trim()==='ciklus vége'){
    newlineOut("}");
    forCiklusbanVan=false;
  }
  else{
    for(i=0;i<line.split(' ').length;i++){
      let kifejezes=line.split(' ')[i];
      if(kifejezes==='ciklus'){
        kifejezes=line.split(' ')[++i];
        if(kifejezes==='amíg' ){
          sor=whileCiklisFromInput(line);
          newlineOut(sor);
        }else{
        sor=forciklusFromInput(line);
        newlineOut(sor)
        forCiklusbanVan=true;
        }
        break;
      }
      else if(kifejezes==='be:'){
        valtozokBeker=valtozokBeFromInput(line);
        let valtKiir=''
        for (let [key, value] of Object.entries(valtozok)) {
          valtKiir+=`${key}: ${value}`;
        }
        valtozokErtekKiir(valtozokBeker);
        valtozokErtekBeker(valtozokBeker);
        document.getElementById('valtozokBeker').addEventListener('click',function(e){
        for (let [key, value] of Object.entries(valtozokBeker)) {
          valtozokBeker[key]=document.getElementById(key).value;
        }
        arrayConcatination(valtozok,valtozokBeker);
        valtozokErtekKiir(valtozok);
        let x=document.getElementById("valtozokBe")
        x.style.display='none';
      });
      break;
    }
      else if(kifejezes==='ha'){
        if(line.split(' ')[++i]=='különben'){
          
          feltetelElseIfFromInput(line);
        }else{
        feltetelFromInput(line);
          ifbenVan=true;
          
        }
        break;
    }
    else if(kifejezes==='különben'){
      newlineOut('}<br>else {')
      break;
    }
    else if(line.includes(":=")){
      valtozokFromTextarea(line);
      break;
    }
    else {
      newlineOut('&#8194'+line+";");
      break;
    }
  
  }
  
}
}
function whileCiklisFromInput(line){
  line=line.replaceAll("=","===")
  line=line.replaceAll("<","&lt;")
  line=line.replaceAll(">","&gt;")
  const a=line.split(" ");
  let out='while( ';
  
  for(let i=2;i<a.length;i++){
    if(a[i]==='és'){
      out+=' && ';
    }
    else if(a[i]==='vagy'){
      out+=' || '
    }else{
      out+=a[i];
    }
  }
  
    out+=" ) {";  
    return out;
}
function arrayConcatination(valt,valt2){
  for (let [key, value] of Object.entries(valt2)) {
    valt[key]=valt2[key];
    
  }
}
function valtozokFromTextarea(line){
  let a=line.split(":=");
  let b=a[1].split(",");
  if(b.length>2){
    let tomb=[];
    for(let c in b){
      tomb.push(b[c])
    }
    valtozok[a[0]]=tomb;
  }else{
    valtozok[a[0]]=a[1];
  }
  valtozokErtekKiir(valtozok);
}

function feltetelElseIfFromInput(line){
  let out=`}<br> else if (`;
  line=line.replaceAll("=","===")
  line=line.replaceAll("<","&lt;")
  line=line.replaceAll(">","&gt;")
  sor=line.split(' ');
  for(let i=2;i<sor.length;i++){
    if(sor[i]==='és'){
      out+=' && ';
    }
    else if(sor[i]==='vagy'){
      out+=' || '
    }else{
      out+=sor[i];
    }
  }
  out+=') {';
  newlineOut(out);
}
function feltetelFromInput(line){
  line=line.replaceAll("=","===")
  line=line.replaceAll("<","&lt;")
  line=line.replaceAll(">","&gt;")
  let out=`if (`;
  sor=line.split(' ');
  
  for(let i=1;i<sor.length;i++){
    if(sor[i]==='és'){
      out+=' && ';
    }
    else if(sor[i]==='vagy'){
      out+=' || '
    }else{
      out+=sor[i];
    }
  }
  out+=') {';
  newlineOut(out);
}
function forciklusFromInput(text){
  text=text.replace('ciklus','');
  text=text.trim();
  text=text.replace('..',' ');
  
  const b=text.split(" ");
  const iterator=b[0];
  let sor=`for (${iterator}${b[1]}`;
 
  if(b[2]<b[3]){
    sor+=b[2]+`; ${iterator}<`;
    sor+=`${b[3]}; ${iterator}++){`;
  }else{
    sor+=b[2]+`; ${iterator}>`;
    sor+=`${b[3]}; ${iterator}--){`;
  }
 
  
  
  return sor;
}

function valtozokBeFromInput(line){
  line=line.replaceAll(',',' ');
  valt={};
  for(i=1;i<line.split(' ').length;i++){
    if(line.split(' ')[i]!==''){
       valt[line.split(' ')[i]]='';
    }
   
  }
  return valt;
}

function newlineOut(sor){
  let kiir=document.getElementById("eredmeny").innerHTML;
  kiir+=`<br> ${sor}`;
  document.getElementById("eredmeny").innerHTML=kiir;
  
}
function valtozokErtekBeker(valtozok){
  for (let [key, value] of Object.entries(valtozok)) {
    var y=document.createElement("label");
    y.setAttribute("for",key);
    y.innerHTML=key+": ";
    var x = document.createElement("INPUT");
    x.setAttribute("type", "text");
    x.setAttribute("id",key);
    x.size=1;
    x.style.marginRight="10px";
    const parent=document.getElementById("valtozokBe");
    parent.appendChild(y);
    parent.appendChild(x);
    
  }
  var x=document.createElement("INPUT");
  x.setAttribute("type","submit");
  x.setAttribute("value","Megadás");
  x.setAttribute("id","valtozokBeker");
  document.getElementById("valtozokBe").appendChild(x);
}

function valtozokErtekKiir(valtozok){
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
String.prototype.replaceAll = function(search, replacement) {
  var target = this;
  return target.split(search).join(replacement);
};
