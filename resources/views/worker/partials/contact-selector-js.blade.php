{{-- Contact selector JavaScript for auto-filling client data --}}
@if(isset($contacts) && $contacts->count() > 0)
<script>
    const savedContacts = @json($contacts);

    function toggleContactDropdown() {
        const dropdown = document.getElementById('contact-dropdown');
        // Close other custom dropdowns first
        document.querySelectorAll('.custom-select-dropdown').forEach(dd => {
            if (dd.id !== 'contact-dropdown') dd.classList.remove('active');
        });
        dropdown.classList.toggle('active');
        if (dropdown.classList.contains('active')) {
            setTimeout(() => document.getElementById('contactSearchInput').focus(), 100);
        }
    }

    function filterContacts() {
        const term = document.getElementById('contactSearchInput').value.toLowerCase();
        document.querySelectorAll('#contact-options .custom-select-option').forEach(opt => {
            const searchText = opt.getAttribute('data-search') || '';
            opt.style.display = searchText.includes(term) ? 'block' : 'none';
        });
    }

    function selectContact(contactId) {
        const contact = savedContacts.find(c => c.id === contactId);
        if (!contact) return;

        // Update the selector display text
        const displayName = contact.type === 'fizicko_lice' ? contact.client_name : contact.company_name;
        const selectValue = document.getElementById('contact_selected_text');
        selectValue.textContent = displayName;
        selectValue.classList.add('selected');

        // Close dropdown
        document.getElementById('contact-dropdown').classList.remove('active');

        // Set client type radio
        const radio = document.querySelector(`input[name="client_type"][value="${contact.type}"]`);
        if (radio) {
            radio.checked = true;
            radio.dispatchEvent(new Event('change', { bubbles: true }));
            toggleClientFields();
        }

        // Auto-fill fields based on type
        if (contact.type === 'fizicko_lice') {
            setFieldValue('client_name', contact.client_name);
            setFieldValue('client_address', contact.client_address);
        } else {
            setFieldValue('company_name', contact.company_name);
            setFieldValue('pib', contact.pib);
            setFieldValue('maticni_broj', contact.maticni_broj);
            setFieldValue('company_address', contact.company_address);
        }

        // Common fields
        setFieldValue('client_phone', contact.client_phone);
        setFieldValue('client_email', contact.client_email);

        // Hide save-as-contact checkbox since we selected an existing contact
        const saveCheckbox = document.getElementById('save-contact-checkbox');
        if (saveCheckbox) saveCheckbox.style.display = 'none';
        const saveInput = document.getElementById('save_as_contact');
        if (saveInput) saveInput.checked = false;
    }

    function setFieldValue(fieldName, value) {
        // Collect all matching elements (by name and by id), deduplicated
        const seen = new Set();
        const selector = `input[name="${fieldName}"], textarea[name="${fieldName}"], [id="${fieldName}"]`;
        document.querySelectorAll(selector).forEach(field => {
            if (seen.has(field)) return;
            seen.add(field);
            field.value = value || '';
            // Dispatch both events so form input/change listeners (autosave) fire
            field.dispatchEvent(new Event('input', { bubbles: true }));
            field.dispatchEvent(new Event('change', { bubbles: true }));
        });
    }
</script>
@endif
