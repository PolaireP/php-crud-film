<?php
declare(strict_types=1);

namespace Entity;
use Database\MyPdo;
use PDO;
use Entity\Exception\EntityNotFoundException;
class Film
{
    private ?int $id;
    private ?int $posterId = null;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;


    public function __construct()
    {
    }

    /**
     * @param int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): void
    {
        $this->originalLanguage = $originalLanguage;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): void
    {
        $this->originalTitle = $originalTitle;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param int $id Identifiant du film
     * @return Film Instance récupérée
     */
    public static function findById(int $id):Film {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id, posterId, originalLanguage, originalTitle, overview, DATE_FORMAT(releaseDate, "%Y-%m-%d") as releaseDate, runtime, tagline, title
            FROM movie
            WHERE id = :id;
            SQL
        );

        $stmt -> execute([":id" => $id]);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, Film::class);
        if (($request = $stmt->fetch()) !== false) {
            return $request;
        } else {
            throw new EntityNotFoundException('Film introuvable');
        }
    }

    /**
     * @return $this
     */
    public function delete(): Film
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                DELETE FROM movie
                WHERE id = ?
            SQL
        );
        $stmt->execute([$this->id]);
        $this->setId(null);

        return $this;
    }

    /**
     * @return $this
     */
    protected function update(): Film
    {
        $request = MyPdo::getInstance()->prepare(<<<SQL
                UPDATE movie
                SET originalLanguage = :originalLanguage,
                    originalTitle = :originalTitle,
                    overview = :overview,
                    runtime = :runtime,
                    tagline = :tagline,
                    title = :title,
                    releaseDate = STR_TO_DATE(:releaseDate, '%Y-%m-%d')
                WHERE id = :id
            SQL);

        $request->execute([':id' => $this->id, ':originalLanguage' => $this->originalLanguage, ':originalTitle' => $this->originalTitle,
            ':overview' => $this->overview, ':releaseDate'=>$this->releaseDate, ':runtime' => $this->runtime, ':tagline' => $this->tagline ,':title' => $this->title]);
        return $this;
    }

    /**
     * @return Film
     */
    protected function insert(): Film
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
                    INSERT INTO movie ( originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title)
                    VALUES (:originalLanguage, :originalTitle, :overview, STR_TO_DATE(:releaseDate, '%Y-%m-%d'), :runtime, :tagline, :title)
                SQL
        );

        $stmt->execute([':originalLanguage' => $this->originalLanguage, ':originalTitle' => $this->originalTitle,
            ':overview' => $this->overview, ':releaseDate'=>$this->releaseDate ,':runtime' => $this->runtime, ':tagline' => $this->tagline ,':title' => $this->title]);
        $this->id = intval(MyPdo::getInstance()->lastInsertId());

        return $this;
    }

    /**
     * @param int|null $id
     * @param string $originalLanguage
     * @param string $originalTitle
     * @param string $overview
     * @param string $releaseDate
     * @param int $runtime
     * @param string $tagline
     * @param string $title
     * @return Film
     */
    public static function create(?int $id=null, string $originalLanguage, string $originalTitle, string $overview,
                                  string $releaseDate, int $runtime, string $tagline, string $title ): Film
    {
        $film = new Film();
        $film->setId($id);
        $film->setOverview($overview);
        $film->setOriginalLanguage($originalLanguage);
        $film->setOriginalTitle($originalTitle);
        $film->setOverview($overview);
        $film->setReleaseDate($releaseDate);
        $film->setRuntime($runtime);
        $film->setTagline($tagline);
        $film->setTitle($title);
        return $film;
    }


    /**
     * @return void
     */
    public function save()
    {
        if ($this->id === null) {
            $this->insert();
        } else {
            $this->update();
        }
    }

}