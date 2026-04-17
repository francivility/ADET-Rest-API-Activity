<?php require 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZenFit | Elite Membership</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #050505; color: white; font-family: 'Inter', sans-serif; }
        .glass { background: rgba(15, 15, 15, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); }
        .plan-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid #1a1a1a; }
        .plan-card:hover { border-color: #10b981; transform: translateY(-5px); box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.2); }
        .selected { border-color: #10b981 !important; background: rgba(16, 185, 129, 0.05) !important; }
        .emerald-dot { height: 8px; width: 8px; background-color: #10b981; border-radius: 50%; display: inline-block; margin-right: 8px; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-4xl w-full">
        <div class="text-center mb-12">
            <h1 class="text-6xl font-black italic tracking-tighter uppercase">Zen<span class="text-emerald-500">Fit</span></h1>
            <p class="text-zinc-500 uppercase text-[10px] tracking-[0.5em] mt-4 font-bold">Forge Your Legacy</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div id="card-Standard" onclick="selectPlan('Standard')" class="plan-card selected p-8 rounded-[2rem] glass cursor-pointer">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-zinc-500 font-bold uppercase tracking-widest text-xs">Standard</h3>
                    <span class="text-white font-black text-2xl">₱500</span>
                </div>
                <ul class="space-y-3 text-xs text-zinc-400 mb-8">
                    <li><span class="emerald-dot"></span> Full Gym Access</li>
                    <li><span class="emerald-dot"></span> Basic Locker Room</li>
                    <li><span class="emerald-dot"></span> 5am - 10pm Access</li>
                </ul>
            </div>

            <div id="card-Premium" onclick="selectPlan('Premium')" class="plan-card p-8 rounded-[2rem] glass cursor-pointer">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-emerald-500 font-bold uppercase tracking-widest text-xs">Premium</h3>
                    <span class="text-white font-black text-2xl">₱900</span>
                </div>
                <ul class="space-y-3 text-xs text-zinc-400 mb-8">
                    <li><span class="emerald-dot"></span> 24/7 All-Access</li>
                    <li><span class="emerald-dot"></span> Sauna & Steam Room</li>
                    <li><span class="emerald-dot"></span> Free Personal Trainer (1 Session)</li>
                </ul>
            </div>
        </div>

        <div class="glass p-10 rounded-[3rem] shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <input type="text" id="fullname" placeholder="NAME" class="w-full bg-black border border-zinc-800 p-5 rounded-2xl outline-none focus:border-emerald-500 transition text-white">
                <input type="email" id="email" placeholder="EMAIL" class="w-full bg-black border border-zinc-800 p-5 rounded-2xl outline-none focus:border-emerald-500 transition text-white">
            </div>
            <button onclick="submitEnrollment()" class="w-full bg-emerald-500 hover:bg-emerald-400 text-black font-black py-5 rounded-2xl uppercase tracking-[0.2em] text-sm transition-all mt-8 shadow-lg shadow-emerald-500/20">
                Activate Membership
            </button>
        </div>
    </div>

    <script>
        let selectedPlan = 'Standard';
        function selectPlan(p) {
            selectedPlan = p;
            document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
            document.getElementById('card-' + p).classList.add('selected');
        }

        async function submitEnrollment() {
            const fn = document.getElementById('fullname').value;
            const em = document.getElementById('email').value;
            if(!fn || !em) return alert("Fill the fields, boss.");

            const res = await fetch('api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({fullname: fn, email: em, membership_type: selectedPlan})
            });
            const data = await res.json();
            if(data.status === 'success') {
                alert("Enrollment Successful! Check your inbox.");
                location.reload();
            }
        }
    </script>
</body>
</html>