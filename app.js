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
  else if(forCiklusbanVan || ifbenVan){
    newlineOut('&#8194'+line);
  }else{
    for(i=0;i<line.split(' ').length;i++){
      let kifejezes=line.split(' ')[i];
      if(kifejezes==='ciklus'){
        sor=forciklus(line.split(' ')[++i]);
        newlineOut(sor)
        forCiklusbanVan=true;
        
      }
      if(kifejezes==='be:'){
        valtozok=valtozokBe(line);
        let valtKiir=''
        for (let [key, value] of Object.entries(valtozok)) {
          valtKiir+=`${key}: ${value}`;
      }
      valtozokErtekKiir(valtozok);
      valtozokErtekBeker(valtozok);
      document.getElementById('valtozokBeker').addEventListener('click',function(e){
        for (let [key, value] of Object.entries(valtozok)) {
          valtozok[key]=document.getElementById(key).value;
        }
        valtozokErtekKiir(valtozok);
      });
    }
    if(kifejezes==='ha'){
        feltetel(line);
        ifbenVan=true;
    }
    
  }
}
}
function feltetel(line){
  let out='if(';
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
function forciklus(text){
  
  let sor="for(i=";
  sor+=text[0]+'; i<';
  let a=3;
  while(a<text.length){
    sor+=text[a];
    a++;
  }
  sor+="; i++){";
  return sor;
}

function valtozokBe(line){
  line=line.replaceAll(',',' ');
  valtozok={};
  for(i=1;i<line.split(' ').length;i++){
    if(line.split(' ')[i]!==''){
       valtozok[line.split(' ')[i]]='';
    }
   
  }
  return valtozok;
}

function newlineOut(sor){
  let kiir=document.getElementById("eredmeny").innerHTML;
  kiir+=`<br> ${sor}`;
  document.getElementById("eredmeny").innerHTML=kiir;
  //console.log(sor);
}
function valtozokErtekBeker(valtozok){
  for (let [key, value] of Object.entries(valtozok)) {
    var x = document.createElement("INPUT");
    x.setAttribute("type", "text");
    x.setAttribute("id",key);
    x.size=1;
    x.style.marginRight="10px";
    const parent=document.getElementById("valtozokBe");
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
