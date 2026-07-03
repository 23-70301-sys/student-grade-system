document.addEventListener('DOMContentLoaded', function () {
    setupPasswordToggle();
    setupLoginValidation();
    setupGradesTable();
});


function setupPasswordToggle() {
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (!toggleBtn || !passwordInput) return;

    toggleBtn.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        toggleBtn.textContent = isHidden ? 'Hide' : 'Show';
        toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
    });
}

function setupLoginValidation() {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');

    form.addEventListener('submit', function (e) {
        let isValid = true;

        usernameError.textContent = '';
        passwordError.textContent = '';
        usernameInput.classList.remove('input-invalid');
        passwordInput.classList.remove('input-invalid');

        const usernameValue = usernameInput.value.trim();

        if (usernameValue === '') {
            usernameError.textContent = 'Username is required.';
            usernameInput.classList.add('input-invalid');
            isValid = false;
        }

        const passwordValue = passwordInput.value.trim();

        if (passwordValue === '') {
            passwordError.textContent = 'Password is required.';
            passwordInput.classList.add('input-invalid');
            isValid = false;
        } else if (passwordValue.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters.';
            passwordInput.classList.add('input-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    [usernameInput, passwordInput].forEach(function (input) {
        input.addEventListener('input', function () {
            input.classList.remove('input-invalid');
            const errorSpan = input.id === 'username' ? usernameError : passwordError;
            errorSpan.textContent = '';
        });
    });
}


function setupGradesTable() {
    const table = document.getElementById('gradesTable');
    if (!table) return;

    const searchInput = document.getElementById('gradeSearch');
    const statusFilter = document.getElementById('statusFilter');
    const exportBtn = document.getElementById('exportCsvBtn');
    const noResultsMsg = document.getElementById('noResultsMsg');
    const tbody = table.querySelector('tbody');
    const headers = table.querySelectorAll('thead th[data-sort]');

    function applyFilters() {
        const query = (searchInput.value || '').trim().toLowerCase();
        const status = statusFilter.value;
        let visibleCount = 0;

        tbody.querySelectorAll('tr').forEach(function (row) {
            const matchesSearch = !query || row.dataset.search.includes(query);
            const matchesStatus = status === 'all' || row.dataset.status === status;
            const show = matchesSearch && matchesStatus;
            row.classList.toggle('row-hidden', !show);
            if (show) visibleCount++;
        });

        noResultsMsg.hidden = visibleCount !== 0;
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);

    let currentSort = { key: null, dir: 1 };

    headers.forEach(function (th) {
        th.addEventListener('click', function () {
            const key = th.dataset.sort;
            const type = th.dataset.type || 'string';

            currentSort.dir = currentSort.key === key ? currentSort.dir * -1 : 1;
            currentSort.key = key;

            headers.forEach(function (h) { h.classList.remove('sort-asc', 'sort-desc'); });
            th.classList.add(currentSort.dir === 1 ? 'sort-asc' : 'sort-desc');

            const colIndex = Array.from(th.parentElement.children).indexOf(th);
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort(function (a, b) {
                const aVal = a.children[colIndex].dataset.value;
                const bVal = b.children[colIndex].dataset.value;

                if (type === 'number') {
                    return (parseFloat(aVal) - parseFloat(bVal)) * currentSort.dir;
                }
                return aVal.localeCompare(bVal) * currentSort.dir;
            });

            rows.forEach(function (row) { tbody.appendChild(row); });
        });
    });

    if (exportBtn) {
        exportBtn.addEventListener('click', function () {
            exportTableToCsv(table);
        });
    }

    applyFilters();
}

function exportTableToCsv(table) {
    const rows = [];
    const headerCells = table.querySelectorAll('thead th');
    rows.push(Array.from(headerCells).map(function (th) {
        return csvEscape(th.textContent.trim());
    }).join(','));

    table.querySelectorAll('tbody tr').forEach(function (tr) {
        if (tr.classList.contains('row-hidden')) return;
        const cells = Array.from(tr.children).map(function (td) {
            return csvEscape(td.dataset.value !== undefined ? td.dataset.value : td.textContent.trim());
        });
        rows.push(cells.join(','));
    });

    const csvContent = rows.join('\r\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');
    link.href = url;
    link.download = 'grades-export.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

function csvEscape(value) {
    const str = String(value ?? '');
    if (/[",\n]/.test(str)) {
        return '"' + str.replace(/"/g, '""') + '"';
    }
    return str;
}
