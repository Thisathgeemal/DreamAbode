<x-app-layout>

    <!-- Header -->
    <div class="w-full px-8 py-6 bg-[#161616] rounded-lg text-left mx-auto shadow-md mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl text-white font-bold">My Reviews</h2>
                <p class="text-sm text-gray-300 mt-1">See all the feedback you’ve added about the platform.</p>
            </div>

            <button id="openReviewModal"
                class="flex items-center gap-2 px-5 py-2.5 bg-[#5CFFAB] text-black rounded-xl font-medium shadow-md 
                hover:bg-[#35db88] hover:shadow-lg transition-all duration-200 ease-in-out">
                <i class="fas fa-plus inline sm:hidden"></i>
                <span class="hidden sm:inline">Add Review</span>
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="w-full p-8 bg-white rounded-lg text-left mx-auto shadow-md mb-6">
        <div id="member-reviews" class="flex flex-wrap gap-8 justify-center p-6 overflow-y-auto custom-scrollbar">
            <!-- Cards will be injected here dynamically -->
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 hidden bg-black bg-opacity-50 justify-center items-center z-50">
        <div class="bg-white rounded-lg w-full max-w-md p-6 relative shadow-[0_0_15px_4px_rgba(92,255,171,0.4)]">
            <h3 class="text-2xl font-bold text-center mb-4">Add Your Review</h3>

            <!-- Star Rating -->
            <div class="flex justify-center mb-6 space-x-2" id="starRating">
                @for ($i = 1; $i <= 5; $i++)
                    <span data-value="{{ $i }}"
                        class="star cursor-pointer text-gray-300 text-3xl">&#9733;</span>
                @endfor
            </div>

            <!-- Description -->
            <textarea id="reviewDescription" rows="4"
                class="w-full border rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#5CFFAB]"
                placeholder="Write your feedback about the platform..."></textarea>

            <!-- Actions -->
            <div class="flex justify-end mt-4 gap-4">
                <button id="closeReviewModal"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition">Cancel</button>
                <button id="submitReview"
                    class="px-4 py-2 rounded-lg bg-[#5CFFAB] hover:bg-[#35db88] text-black font-medium shadow transition">Submit</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const token = "{{ auth()->user()->createToken('authToken')->plainTextToken ?? '' }}";
            let selectedRating = 0;

            document.addEventListener('DOMContentLoaded', () => {
                setupModalHandlers();
                setupStarRating();
                setupReviewSubmission();
                fetchMemberReviews();
            });

            function setupModalHandlers() {
                const modal = document.getElementById('reviewModal');
                document.getElementById('openReviewModal').addEventListener('click', () => toggleModal(modal, true));
                document.getElementById('closeReviewModal').addEventListener('click', () => toggleModal(modal, false));
            }

            function toggleModal(modal, show) {
                modal.classList.toggle('hidden', !show);
                modal.classList.toggle('flex', show);
            }

            function setupStarRating() {
                const stars = document.querySelectorAll('#starRating .star');
                stars.forEach((star, idx) => {
                    star.addEventListener('click', () => {
                        selectedRating = idx + 1;
                        updateStarDisplay(stars, selectedRating);
                    });
                });
            }

            function updateStarDisplay(stars, rating) {
                stars.forEach((star, i) => {
                    star.classList.toggle('text-yellow-400', i < rating);
                });
            }

            function setupReviewSubmission() {
                document.getElementById('submitReview').addEventListener('click', async () => {
                    const description = document.getElementById('reviewDescription').value.trim();
                    if (!validateReviewForm(selectedRating, description)) return;
                    try {
                        await submitReview(selectedRating, description);
                        showSuccess('Review added successfully!');
                        resetReviewForm();
                        fetchMemberReviews();
                    } catch (error) {
                        console.error(error);
                        showError('Failed to add review. Please try again.');
                    }
                });
            }

            function validateReviewForm(rating, description) {
                if (rating === 0) {
                    showError('Please select a rating.');
                    return false;
                }
                if (!description) {
                    showError('Please enter a description.');
                    return false;
                }
                return true;
            }

            async function submitReview(rating, description) {
                await axios.post('/api/reviews', {
                    rating,
                    description,
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
            }

            function resetReviewForm() {
                const modal = document.getElementById('reviewModal');
                toggleModal(modal, false);
                document.getElementById('reviewDescription').value = '';
                selectedRating = 0;
                updateStarDisplay(document.querySelectorAll('#starRating .star'), selectedRating);
            }

            async function fetchMemberReviews() {
                const container = document.getElementById('member-reviews');
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
                    renderReviews(container, response.data.user_reviews);
                } catch (error) {
                    console.error('Error fetching reviews:', error);
                    showError('Failed to fetch your reviews. Please try again.');
                }
            }

            function renderReviews(container, reviews) {
                container.innerHTML = '';
                if (!reviews || reviews.length === 0) {
                    container.innerHTML = `
                        <p class="flex justify-center items-center text-center text-green-500 text-lg">
                            You haven’t added any reviews yet.
                        </p>`;
                    return;
                }
                reviews.forEach(review => container.appendChild(createReviewCard(review)));
            }

            function createReviewCard(review) {
                const card = document.createElement('div');
                card.className =
                    'w-[320px] bg-[#5CFFAB] rounded-2xl shadow-lg hover:shadow-xl overflow-hidden p-6 flex flex-col justify-start items-center text-center relative transform transition duration-300 ease-in-out hover:scale-105';

                // Trashcan icon 
                const deleteBtn = document.createElement('button');
                deleteBtn.innerHTML =
                    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-red-500 hover:text-red-700 transition absolute top-2 right-2"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;
                deleteBtn.title = 'Delete Review';
                deleteBtn.className = 'absolute top-2 right-2 bg-transparent border-none p-0 m-0 cursor-pointer';
                deleteBtn.onclick = () => confirmDeleteReview(review._id || review.id, card);
                card.appendChild(deleteBtn);

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
                desc.className = 'text-sm text-gray-700 leading-relaxed';
                desc.textContent = review.description || '';
                card.appendChild(desc);

                return card;
            }

            function confirmDeleteReview(reviewId, cardElement) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This review will be permanently deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            await axios.delete(`/api/reviews/${reviewId}`, {
                                headers: {
                                    Authorization: `Bearer ${token}`
                                }
                            });
                            showSuccess('Review deleted successfully!');
                            cardElement.remove();
                        } catch (error) {
                            console.error(error);
                            showError('Failed to delete review. Please try again.');
                        }
                    }
                });
            }

            function createProfileImage(member) {
                if (member && member.profile_photo_path) {
                    const img = document.createElement('img');
                    img.src = `/storage/${member.profile_photo_path}`;
                    img.alt = member.name ? `${member.name}'s Review` : 'User Review';
                    img.className = 'w-20 h-20 object-cover mb-4 rounded-full shadow-md';
                    return img;
                } else {
                    const initial = (member?.name || 'U')[0].toUpperCase();
                    const div = document.createElement('div');
                    div.textContent = initial;
                    div.className =
                        'w-20 h-20 flex items-center justify-center mb-4 rounded-full shadow-md bg-gray-400 text-white text-2xl font-bold';
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

</x-app-layout>
