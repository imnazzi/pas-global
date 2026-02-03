// Minimal JS for polling notifications, flash messages, and basic interactions
(function(){
    function showFlash(message, type='success', timeout=5000){
        var container = document.getElementById('flashMessage');
        if (!container) return;
        container.innerHTML = '<div class="alert alert-'+(type==='success'?'success':'danger')+'">'+message+'</div>';
        container.style.display = 'block';
        setTimeout(function(){ container.style.display = 'none'; container.innerHTML=''; }, timeout);
    }

    window.showFlash = showFlash; // expose globally

    function fetchUnreadCount(){
        fetch('api/notifications_unread_count.php').then(r=>r.json()).then(j={
            if (j.success){
                var b = document.getElementById('notifBadge');
                if (b){
                    if (j.count>0){ b.style.display='inline-block'; b.textContent = j.count; } else { b.style.display='none'; }
                }
            }
        }).catch(()=>{});
    }
    function fetchNotifications(){
        fetch('api/notifications_list.php').then(r=>r.json()).then(j={
            var menu = document.getElementById('notifDropdownMenu');
            if (!menu) return;
            menu.innerHTML = '';
            if (!j.success || !j.items || j.items.length===0){
                menu.innerHTML = '<li class="text-center small text-muted">No notifications</li>';
                return;
            }
            j.items.forEach(function(it){
                var li = document.createElement('li');
                var a = document.createElement('a');
                a.href = '#';
                a.className = 'dropdown-item';
                a.dataset.id = it.id;
                a.dataset.type = it.type;
                a.dataset.ref = it.reference_id;
                a.innerHTML = '<div class="fw-bold">'+escapeHtml(it.title)+'</div><div class="small text-muted">'+escapeHtml(it.message || '')+' &middot; '+it.created_at+'</div>';
                a.addEventListener('click', function(e){
                    e.preventDefault();
                    // mark read then navigate
                    fetch('api/notifications_mark_read.php', {method:'POST', body: new URLSearchParams({id: it.id})}).then(()=>{
                        fetchUnreadCount();
                        // navigate based on type
                        var url = '#';
                        switch(it.type){
                            case 'message':
                                // open conversation
                                if (it.role === 'admin') url = '?page=messages_view&admin_id='+it.receiver_id+'&user_id='+it.reference_id;
                                else url = '?page=messages_view&admin_id='+it.reference_id+'&user_id='+it.receiver_id;
                                break;
                            case 'community': url='?page=community_view&id='+it.reference_id; break;
                            case 'video': url='?page=videos_view&id='+it.reference_id; break;
                            case 'forum': url='?page=forum_view&id='+it.reference_id; break;
                            case 'calendar': url='?page=calendar_view&id='+it.reference_id; break;
                            default: url='#';
                        }
                        if (url !== '#') location.href = url; else {
                            // remove item visually
                            e.target.parentElement.removeChild(e.target);
                        }
                    });
                });
                li.appendChild(a);
                menu.appendChild(li);
            });
            // add mark all
            var li2 = document.createElement('li');
            li2.className = 'mt-1';
            li2.innerHTML = '<div class="text-center"><button id="markAllNotif" class="btn btn-sm btn-link">Mark all as read</button></div>';
            menu.appendChild(li2);
            var btn = document.getElementById('markAllNotif');
            if (btn) btn.addEventListener('click', function(){ fetch('api/notifications_mark_all.php',{method:'POST'}).then(()=>{ fetchUnreadCount(); fetchNotifications(); }); });
        }).catch(()=>{});
    }
    function escapeHtml(s){ return String(s||'').replace(/[&<>\"]/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }

    // initial fetch
    fetchUnreadCount();
    // poll every 12s
    setInterval(fetchUnreadCount, 12000);

    // open dropdown fetch
    var dropdown = document.getElementById('notifDropdown');
    if (dropdown){ dropdown.addEventListener('click', function(){ fetchNotifications(); }); }

})();
