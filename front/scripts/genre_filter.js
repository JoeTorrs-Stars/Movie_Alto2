
     $(document).ready(function() {
            let selectedGenres = [];
            let selectedYears = [];

            // Click event for genre badges
            $('.genre-badge').on('click', function() {
                const genre = $(this).data('genre');

                // Toggle the selection
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    selectedGenres.push(genre);
                } else {
                    selectedGenres = selectedGenres.filter(g => g !== genre);
                }

                updateFilters();
            });

            // Click event for year badges
            $('.year-badge').on('click', function() {
                const year = $(this).data('year');

                // Toggle the selection
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    selectedYears.push(year);
                } else {
                    selectedYears = selectedYears.filter(y => y !== year);
                }

                updateFilters();
            });

            // Function to update the selected filters display
            function updateFilters() {
                $('#selected-filters').html('');
                selectedGenres.forEach(g => {
                    $('#selected-filters').append(`<span class="badge bg-primary">${g}</span> `);
                });
                selectedYears.forEach(y => {
                    $('#selected-filters').append(`<span class="badge bg-secondary">${y}</span> `);
                });

                // Trigger search
                searchMovies();
            }

            // Function to search movies based on selected filters
            function searchMovies() {
                const queryString = $.param({ genres: selectedGenres, years: selectedYears });
                
                $.ajax({
                    url: 'search.php', // Adjust this based on your actual search script
                    method: 'GET',
                    data: queryString,
                    success: function(data) {
                        $('#results').html(data);
                    },
                    error: function() {
                        $('#results').html('<p>Error fetching results.</p>');
                    }
                });
            }
        });