@extends('layouts.ams')

@section('title', 'Shipping Markups')

@section('content')
    <div class="container my-5">
        <h1 class="text-center mb-4">Shipping Markups Cost By States</h1>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-center align-middle" style="font-size: 14px;">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>State</th>
                        <th>Markup</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stateMarkups as $stateMarkup)
                        <tr>
                            <td>{{ $stateMarkup->id }}</td>
                            <td>{{ $stateMarkup->state }}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm text-center markup-input"
                                    data-id="{{ $stateMarkup->id }}" value="{{ number_format($stateMarkup->markup, 2) }}"
                                    step="0.01" />
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm update-markup-btn" data-id="{{ $stateMarkup->id }}">
                                    Update
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for click events on the "Update" buttons
        document.querySelectorAll('.update-markup-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id; // Get the ID of the row
                const input = document.querySelector(`.markup-input[data-id="${id}"]`);
                const newMarkup = input.value; // Get the updated markup value

                // Validate the input
                if (newMarkup === '' || parseFloat(newMarkup) < 0) {
                    alert('Please enter a valid markup value.');
                    return;
                }

                // Disable the button and show loading state
                const button = this;
                button.innerHTML = 'Updating...';
                button.disabled = true;

                // Send AJAX request to update the markup
                fetch(`/shipping-markup/${id}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            markup: newMarkup
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Markup updated successfully!');
                        } else {
                            alert('Failed to update markup. Please try again.');
                        }
                    })  
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the markup.');
                    })
                    .finally(() => {
                        // Re-enable the button and restore the original text
                        button.innerHTML = 'Update';
                        button.disabled = false;
                    });
            });
        });
    });
</script>
