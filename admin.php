<?php require 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZenFit Staff | Command Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <style>
        body { background: #050505; color: #ccc; }
        .glass { background: rgba(20, 20, 20, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); }
        .admin-card { border: 1px solid #1a1a1a; transition: all 0.3s; }
        .admin-card:hover { border-color: #333; }
        .plan-option { border: 2px solid #1a1a1a; transition: all 0.2s; cursor: pointer; }
        .plan-option.active { border-color: #10b981; background: rgba(16, 185, 129, 0.05); }
        .perk-dot { height: 6px; width: 6px; background: #10b981; border-radius: 50%; display: inline-block; margin-right: 8px; }
    </style>
</head>
<body class="p-6 md:p-10 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-10 border-b border-zinc-900 pb-8">
            <h1 class="text-3xl font-black text-white italic tracking-tighter uppercase">Zen<span class="text-emerald-500">Fit</span> <span class="text-zinc-700 not-italic font-normal text-xs ml-3 tracking-[0.3em]">Staff Portal</span></h1>
            <div id="g_id_onload" data-client_id="<?= GOOGLE_CLIENT_ID ?>" data-callback="handleAuth"></div>
            <div class="g_id_signin" data-type="standard"></div>
        </div>

        <div id="lock-screen" class="text-center py-32 border border-dashed border-zinc-800 rounded-[3rem]">
            <div class="text-5xl mb-4">🔐</div>
            <h2 class="text-white font-bold uppercase tracking-widest">Authorized Personnel Only</h2>
            <p class="text-zinc-600 text-sm mt-2">Sign in with Google to manage memberships.</p>
        </div>

        <div id="staff-view" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-4 space-y-6">
                <div class="glass p-8 rounded-[2.5rem] admin-card">
                    <h2 class="text-white font-black text-sm mb-6 uppercase tracking-widest flex items-center">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full mr-3"></span> New Walk-in Enrollment
                    </h2>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div id="opt-Standard" onclick="selectWalkinPlan('Standard')" class="plan-option active p-4 rounded-2xl">
                            <p class="text-[10px] font-bold text-zinc-500 uppercase">Standard</p>
                            <p class="text-lg font-black text-white">₱500</p>
                        </div>
                        <div id="opt-Premium" onclick="selectWalkinPlan('Premium')" class="plan-option p-4 rounded-2xl">
                            <p class="text-[10px] font-bold text-emerald-500 uppercase">Premium</p>
                            <p class="text-lg font-black text-white">₱900</p>
                        </div>
                    </div>

                    <div id="perks-display" class="bg-black/40 p-5 rounded-2xl mb-6 border border-zinc-800/50">
                        <p class="text-[9px] font-bold text-zinc-500 uppercase mb-3 tracking-widest">Included Perks:</p>
                        <ul id="perk-list" class="space-y-2 text-[11px] text-zinc-400">
                            </ul>
                    </div>

                    <div class="space-y-4">
                        <input type="text" id="w_name" placeholder="Member Full Name" class="w-full bg-black border border-zinc-800 p-4 rounded-xl focus:border-emerald-500 outline-none text-white text-sm">
                        <input type="email" id="w_email" placeholder="Email Address" class="w-full bg-black border border-zinc-800 p-4 rounded-xl focus:border-emerald-500 outline-none text-white text-sm">
                        <button onclick="executeWalkin()" class="w-full bg-emerald-500 hover:bg-emerald-400 text-black font-black py-4 rounded-xl uppercase tracking-widest transition-all text-xs">
                            Confirm Onsite Enrollment
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 glass rounded-[2.5rem] admin-card overflow-hidden">
                <div class="p-6 border-b border-zinc-900 flex justify-between items-center">
                    <h3 class="text-zinc-500 font-bold text-[10px] uppercase tracking-widest">Recent Applicants</h3>
                    <button onclick="loadDatabase()" class="text-[10px] text-emerald-500 font-bold hover:underline">Sync Database</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-black/40 text-zinc-600 text-[9px] uppercase font-black">
                            <tr>
                                <th class="p-6">Member Info</th>
                                <th class="p-6">Plan</th>
                                <th class="p-6">Created</th>
                                <th class="p-6 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody id="db-list" class="divide-y divide-zinc-900/50">
                            </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        let selectedPlan = 'Standard';
        const perks = {
            'Standard': ['Full Gym Access', 'Standard Locker Room', 'Valid for 30 Days'],
            'Premium': ['24/7 VIP Access', 'Sauna & Steam Room', 'Free Trainer Session', 'Priority Parking']
        };

        function selectWalkinPlan(p) {
            selectedPlan = p;
            document.querySelectorAll('.plan-option').forEach(el => el.classList.remove('active'));
            document.getElementById('opt-' + p).classList.add('active');
            updatePerks();
        }

        function updatePerks() {
            const list = document.getElementById('perk-list');
            list.innerHTML = perks[selectedPlan].map(perk => `<li><span class="perk-dot"></span> ${perk}</li>`).join('');
        }

        function handleAuth(response) {
            document.getElementById('lock-screen').classList.add('hidden');
            document.getElementById('staff-view').classList.remove('hidden');
            updatePerks();
            loadDatabase();
        }

        async function loadDatabase() {
            const res = await fetch('api.php');
            const data = await res.json();
            const list = document.getElementById('db-list');
            list.innerHTML = data.map(m => `
                <tr class="hover:bg-zinc-800/20">
                    <td class="p-6">
                        <div class="text-white font-bold text-sm">${m.fullname}</div>
                        <div class="text-[10px] text-zinc-600">${m.email}</div>
                    </td>
                    <td class="p-6">
                        <span class="text-[10px] font-black italic px-2 py-1 rounded border ${m.membership_type === 'Premium' ? 'text-emerald-500 border-emerald-500/20' : 'text-zinc-400 border-zinc-800'}">
                            ${m.membership_type.toUpperCase()}
                        </span>
                    </td>
                    <td class="p-6 text-zinc-500 text-xs font-mono">${m.expiry_date}</td>
                    <td class="p-6 text-right"><span class="text-emerald-500 text-[10px] font-black tracking-tighter">● ACTIVE</span></td>
                </tr>
            `).join('');
        }

        async function executeWalkin() {
            const name = document.getElementById('w_name').value;
            const email = document.getElementById('w_email').value;
            if(!name || !email) return alert("Missing data!");

            const res = await fetch('api.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({fullname: name, email: email, membership_type: selectedPlan})
            });

            if((await res.json()).status === 'success') {
                alert("Member Registered Successfully!");
                document.getElementById('w_name').value = '';
                document.getElementById('w_email').value = '';
                loadDatabase();
            }
        }
    </script>
</body>
</html>
