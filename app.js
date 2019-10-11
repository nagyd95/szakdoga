
let forCiklusbanVan=false;
let ifbenVan=false;
let valtozok={};
let valtozokBeker={};
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
      newlineOut('}<br>else{')
      break;
    }
    else if(line.includes(":=")){
      valtozokFromTextarea(line);
      break;
    }
    else {
      newlineOut('&#8194'+line);
      break;
    }
  
  }
  
}
}
function whileCiklisFromInput(line){
  const a=line.split(" ");
  let out='while(';
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
    out+="){";
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
  let out=`}<br>else if (`;
  line=line.replaceAll("=","===")
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
  let sor=`for(${iterator}${b[1]}`;
  
  sor+=b[2]+`; ${iterator}<`;
  
  sor+=`${b[3]}; ${iterator}++){`;
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
  //console.log(sor);
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
