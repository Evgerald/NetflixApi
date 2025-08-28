<?php

namespace App\Transformers\Import\Csv;

/**
 * Movie Transformer
 *
 * @version 1.0
 */
class MovieTransformer extends AbstractCsvTransformer
{
    public static function transform(array $row): array
    {
        $row = array_map('trim', $row);

        // Content type
        $contentTypes = ['Movie', 'TV Series', 'Documentary', 'Stand-up Comedy', 'Limited Series'];
        $type = trim($row['content_type'] ?? '');
        $row['content_type'] = in_array($type, $contentTypes, true) ? $type : 'Standard';

        // Genre primary
        $allowedPrimaryGenres = ['Adventure', 'War', 'Sci-Fi', 'Comedy', 'Action'];
        $primaryGenre = trim($row['genre_primary'] ?? '');
        $row['genre_primary'] = in_array($primaryGenre, $allowedPrimaryGenres, true) ? $primaryGenre : 'Action';

        // Genre secondary
        $allowedSecondaryGenres = ['Drama', 'Adventure', 'Thriller', 'Sci-Fi', 'Family'];
        $secondaryGenre = ucfirst(strtolower($row['genre_secondary'] ?? ''));
        $row['genre_secondary'] = in_array($secondaryGenre, $allowedSecondaryGenres, true) ? $secondaryGenre : null;

        // Release year
        // Probably 0 should be changed. Right now to avoid not correct data. Could be used as record without release year
        $releaseYear = trim($row['release_year'] ?? 0);
        $row['release_year'] = ctype_digit($releaseYear) ? $releaseYear : 0;

        // Duration minutes
        $row['duration_minutes'] = is_numeric($row['duration_minutes'] ?? 0) ? (float) $row['duration_minutes'] : 0;

        // Rating
        // Set the strongest rating as default if rating was empty
        $allowedRatings = ['TV-Y', 'NC-17', 'TV-MA', 'TV-Y7', 'TV-14'];
        $rating = trim($row['rating'] ?? '');
        $row['rating'] = in_array($rating, $allowedRatings, true) ? $rating : 'TV-MA';

        // Imdb rating
        $row['imdb_rating'] = is_numeric($row['imdb_rating'] ?? null)
            ? (float)$row['imdb_rating']
            : null;

        // Production budget
        $row['production_budget'] = is_numeric($row['production_budget'] ?? null)
            ? (float)$row['production_budget']
            : null;

        // Box office revenue
        $row['box_office_revenue'] = is_numeric($row['box_office_revenue'] ?? null)
            ? (float)$row['box_office_revenue']
            : null;

        // Number of seasons
        $row['number_of_seasons'] = is_numeric($row['number_of_seasons'] ?? null)
            ? (float)$row['number_of_seasons']
            : null;

        // Number of episodes
        $row['number_of_episodes'] = is_numeric($row['number_of_episodes'] ?? null)
            ? (float)$row['number_of_episodes']
            : null;

        // Is netflix original
        $row['is_netflix_original'] = filter_var(
            $row['is_netflix_original'] ?? false, FILTER_VALIDATE_BOOLEAN
        ) ? 1 : 0;

        $date = $row['added_to_platform'] ?? null;
        $row['added_to_platform'] = self::normalizeDate($date);

        // Content warning
        $row['content_warning'] = filter_var($row['content_warning'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        return $row;
    }
}
