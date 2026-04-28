const root = document.documentElement;
function toggleTheme(){ const next = root.dataset.theme === 'dark' ? 'light' : 'dark'; root.dataset.theme = next; localStorage.setItem('theme', next);} 
function toggleSidebar(){ document.getElementById('sidebar')?.classList.toggle('open'); }
(function initTheme(){ root.dataset.theme = localStorage.getItem('theme') || 'light';})();
setInterval(()=>{const el=document.getElementById('clock'); if(el){el.textContent=new Date().toLocaleString();}},1000);

document.addEventListener('DOMContentLoaded',()=>{
  const search=document.getElementById('globalSearch');
  if(search){search.addEventListener('input',()=>{
    const q=search.value.toLowerCase();
    document.querySelectorAll('[data-search]').forEach(r=>r.style.display=r.dataset.search.toLowerCase().includes(q)?'':'none');
  });}
  const admissions = document.getElementById('admissionsChart');
  if(admissions){
    const labels = JSON.parse(admissions.dataset.labels || '[]');
    const values = JSON.parse(admissions.dataset.values || '[]');
    new Chart(admissions,{type:'line',data:{labels,datasets:[{label:'Admissions',data:values,borderColor:'#3d6aff',backgroundColor:'rgba(61,106,255,.15)',fill:true,tension:.35}]},options:{plugins:{legend:{display:false}}}});
  }
});
