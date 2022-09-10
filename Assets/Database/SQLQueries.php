<?php

class SQLQueries
{

    public static function GetProjectsByParametersQuery(string $language, string $feature, DatabaseConnection $instance): string
    {
        $featureExists = $instance->FeatureExists($feature);
        $languageExists = $instance->LanguageExists($language);
        if ($featureExists || $languageExists) {
            $queryAddition = "SELECT * FROM project ";
            $queryAddition .= "WHERE ";
            $queryAddition .= self::GetProjectsByLanguageQuery($language, $instance) . " ";
            if ($featureExists && $languageExists) {
                $queryAddition .= "AND ";
            }
            $queryAddition .= self::GetProjectsByFeatureQuery($feature, $instance) . " ";
            $queryAddition .= " ORDER BY project_name ASC;";
            return $queryAddition;
        }
        return self::GetAllProjectsQuery();
    }

    public static function GetAllProjectsQuery(): string
    {
        return "SELECT id, project_name, git_directory, details, key_words FROM project ORDER BY project_name ASC ";
    }

    public static function GetProjectsByLanguageQuery(string $language, DatabaseConnection $instance): string
    {
        if ($instance->LanguageExists($language)) {
            return "id IN ( SELECT project_id from project_languages WHERE 
                                language_id IN ( SELECT id from languages WHERE language = '$language' ) ) ";
        }
        return "";
    }

    public static function GetProjectsByFeatureQuery(string $feature, DatabaseConnection $instance): string
    {
        if ($instance->FeatureExists($feature)) {
            return "id IN ( SELECT project_id from project_features WHERE 
                                feature_id IN ( SELECT id from features WHERE feature = '$feature' ) ) ";
        }
        return "";
    }

    public static function GetFeaturesQuery(): string
    {
        return "SELECT feature FROM features; ";
    }

    public static function GetLanguagesQuery(): string
    {
        return "SELECT language FROM languages; ";
    }
}