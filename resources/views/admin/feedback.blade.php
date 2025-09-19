<x-admin-layout>
    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-white font-bold">All Reviews</h2>
                <p class="text-sm text-gray-300 mt-1">View and manage all feedback received on the platform.</p>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div id="admin-reviews" class="flex flex-wrap gap-8 justify-center p-6 overflow-y-auto custom-scrollbar">
            <!-- Cards will be injected here dynamically -->
        </div>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";

            document.addEventListener('DOMContentLoaded', () => {
                fetchAllReviews();
            });

            async function fetchAllReviews() {
                const container = document.getElementById('admin-reviews');
                container.innerHTML = `
                    <p class="flex justify-center items-center text-center text-gray-500 text-lg">
                        Loading reviews, please wait...
                    </p>`;
                try {
                    const response = await axios.get('/api/reviews', {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                    renderReviews(container, response.data.all_reviews);
                } catch (error) {
                    console.error('Error fetching reviews:', error);
                    showError('Failed to fetch reviews. Please try again.');
                }
            }

            function renderReviews(container, reviews) {
                container.innerHTML = '';
                if (!reviews || reviews.length === 0) {
                    container.innerHTML = `
                        <p class="flex justify-center items-center text-center text-green-500 text-lg">
                            No reviews have been received yet.
                        </p>`;
                    return;
                }
                reviews.forEach(review => container.appendChild(createReviewCard(review)));
            }

            function createReviewCard(review) {
                const card = document.createElement('div');
                card.className =
                    'flex-1 max-w-sm w-full bg-[#5CFFAB] rounded-2xl p-6 flex flex-col justify-start items-center text-center shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:bg-[#42e697] hover:shadow-2xl cursor-pointer relative';

                // Profile image or initial
                card.appendChild(createProfileImage(review.member));

                // Username
                const name = document.createElement('h3');
                name.className = 'text-lg font-semibold mb-1';
                name.textContent = review.member?.name || 'Anonymous';
                card.appendChild(name);

                // Rating stars
                card.appendChild(createRatingStars(review.rating));

                // Description
                const desc = document.createElement('p');
                desc.className = 'text-sm text-gray-900 leading-relaxed text-center';
                desc.textContent = review.description || '';
                card.appendChild(desc);


                // Visibility toggle button
                const visibilityBtn = document.createElement('button');
                visibilityBtn.className =
                    'mt-4 px-4 py-2 rounded-lg font-medium shadow transition bg-white text-black border border-gray-300 hover:bg-gray-100';
                visibilityBtn.textContent = review.visibility ? 'Hide Review' : 'Show Review';

                // Visibility status
                const status = document.createElement('span');
                status.className = 'block mt-2 text-xs font-semibold ' + (review.visibility ? 'text-green-600' :
                    'text-red-600');
                status.textContent = review.visibility ? 'Visible' : 'Hidden';

                visibilityBtn.onclick = () => toggleReviewVisibility(review._id || review.id, !review.visibility, card,
                    visibilityBtn, status);
                card.appendChild(visibilityBtn);
                card.appendChild(status);

                return card;
            }

            function createProfileImage(member) {
                if (member && member.profile_photo_path) {
                    const img = document.createElement('img');
                    img.src = `/storage/${member.profile_photo_path}`;
                    img.alt = member.name ? `${member.name}'s Review` : 'User Review';
                    img.className = 'w-[88px] h-[88px] object-cover mb-4 rounded-full shadow-md';
                    return img;
                } else {
                    const initial = (member?.name || 'U')[0].toUpperCase();
                    const div = document.createElement('div');
                    div.textContent = initial;
                    div.className =
                        'w-[88px] h-[88px] flex items-center justify-center mb-4 rounded-full shadow-md bg-gray-400 text-white text-2xl font-bold';
                    return div;
                }
            }

            function createRatingStars(rating) {
                const wrapper = document.createElement('div');
                wrapper.className = 'flex justify-center items-center mb-2';
                for (let i = 1; i <= (rating || 0); i++) {
                    wrapper.innerHTML += '<span class="text-yellow-500 text-xl">&#9733;</span>';
                }
                return wrapper;
            }

            async function toggleReviewVisibility(reviewId, makeVisible, card, btn) {
                try {
                    const url = makeVisible ? `/api/reviews/${reviewId}/show` : `/api/reviews/${reviewId}/hide`;
                    await axios.put(url, {}, {
                        headers: {
                            Authorization: `Bearer ${token}`
                        }
                    });
                    showSuccess(makeVisible ? 'Review is now visible.' : 'Review is now hidden.');
                    // Update UI
                    btn.textContent = makeVisible ? 'Hide Review' : 'Show Review';
                    btn.className =
                        'mt-4 px-4 py-2 rounded-lg font-medium shadow transition bg-white text-black border border-gray-300 hover:bg-gray-100';
                    // Find the status span that is the next sibling of the button
                    const status = btn.nextSibling;
                    if (status && status.tagName === 'SPAN') {
                        status.textContent = makeVisible ? 'Visible' : 'Hidden';
                        status.className = 'block mt-2 text-xs font-semibold ' + (makeVisible ? 'text-green-600' :
                            'text-red-600');
                    }
                } catch (error) {
                    console.error(error);
                    showError('Failed to update review visibility. Please try again.');
                }
            }

            function showSuccess(msg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: msg,
                    confirmButtonColor: '#28a745'
                });
            }

            function showError(msg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg,
                    confirmButtonColor: '#dc3545'
                });
            }
        </script>
    @endpush

</x-admin-layout>
