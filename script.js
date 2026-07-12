  const form = document.getElementById('regForm');
  const formView = document.getElementById('formView');
  const successView = document.getElementById('successView');
  const serialStamp = document.getElementById('serialStamp');
  const receipt = document.getElementById('receipt');
  const resetBtn = document.getElementById('resetBtn');

  function stampSerial(){
    const n = Math.floor(1000 + Math.random()*8999);
    const d = new Date();
    serialStamp.textContent = `FORM REF: TUK-${d.getFullYear()}-${n}`;
    return `TUK-${d.getFullYear()}-${n}`;
  }
  stampSerial();

  function showError(fieldId, show){
    const errEl = document.getElementById('err-' + fieldId);
    if(errEl) errEl.classList.toggle('show', show);
    const inputEl = document.getElementById(fieldId);
    if(inputEl) inputEl.classList.toggle('invalid', show);
  }

  function validate(data){
    let valid = true;

    if(!data.regNumber){ showError('regNumber', true); valid = false; } else { showError('regNumber', false); }
    if(!data.fullName){ showError('fullName', true); valid = false; } else { showError('fullName', false); }
    if(!data.course){ showError('course', true); valid = false; } else { showError('course', false); }
    if(!data.gender){ showError('gender', true); valid = false; } else { showError('gender', false); }

    const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email || '');
    if(!emailOk){ showError('email', true); valid = false; } else { showError('email', false); }

    return valid;
  }

  form.addEventListener('submit', function(e){
    e.preventDefault();

    const data = {
      regNumber: document.getElementById('regNumber').value.trim(),
      fullName: document.getElementById('fullName').value.trim(),
      course: document.getElementById('course').value,
      gender: (form.querySelector('input[name="gender"]:checked') || {}).value || '',
      email: document.getElementById('email').value.trim()
    };

    if(!validate(data)) return;

    const ref = stampSerial();

    receipt.innerHTML = `
      <div><span>Reference</span><span>${ref}</span></div>
      <div><span>Reg. Number</span><span>${data.regNumber}</span></div>
      <div><span>Full Name</span><span>${data.fullName}</span></div>
      <div><span>Course</span><span>${data.course}</span></div>
      <div><span>Gender</span><span>${data.gender}</span></div>
      <div><span>Email</span><span>${data.email}</span></div>
    `;

    formView.style.display = 'none';
    successView.classList.add('show');
  });

  resetBtn.addEventListener('click', function(){
    form.reset();
    ['regNumber','fullName','course','gender','email'].forEach(f => showError(f, false));
    successView.classList.remove('show');
    formView.style.display = 'block';
    stampSerial();
  });
