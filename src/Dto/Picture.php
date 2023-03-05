<?php

declare(strict_types=1);

namespace Baltyre\B2BClient\Dto;

use Baltyre\B2BClient\Exception\NotAllowedException;
use Stringable;

class Picture implements Stringable
{
    public const JPG = "jpg";
    public const JPEG = "jpeg";
    public const PNG = "png";
    public const GIF = "gif";
    public const FORMATS = [
        self::JPG,
        self::JPEG,
        self::PNG,
        self::GIF,
    ];
    public string $uri;
    private string $protocol;
    private string $host;
    private string $id;
    private string $width;
    private string $height;
    private string $ext;

    private function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->parseUri($uri);
    }

    public static function fromApi(?string $data): ?self
    {
        if (!$data) {
            return null;
        }
        return new self($data);
    }

    private function parseUri(string $uri): void
    {
        preg_match(
            "/^(?<protocol>http|https):\/\/(?<host>[a-z0-9.]*)\/(?<id>[a-z0-9-]{36})\/(?<width>[0-9]{1,4})x(?<height>[0-9]{1,4})\.(?<ext>jpg|jpeg|png|gif)$/i",
            $uri,
            $parts
        );
        $this->protocol = $parts["protocol"];
        $this->host = $parts["host"];
        $this->id = $parts["id"];
        $this->width = $parts["width"];
        $this->height = $parts["height"];
        $this->ext = $parts["ext"];
    }

    /** @throws NotAllowedException */
    public function withFormat(int $width, int $height, string $ext = null): self
    {
        if ($width < 1) {
            throw new NotAllowedException("Width must be greater than 0.");
        }
        if ($width > 2000) {
            throw new NotAllowedException("Width must be less than 2000px.");
        }
        if ($height < 1) {
            throw new NotAllowedException("Height must be greater than 0.");
        }
        if ($height > 2000) {
            throw new NotAllowedException("Height must be less than 2000px.");
        }
        if ($ext) {
            $ext = strtolower($ext);
            if (!in_array($ext, self::FORMATS)) {
                throw new NotAllowedException("Only JPG, JPEG, PNG and GIF format is allowed.");
            }
        }
        $uri = sprintf(
            "%s://%s/%s/%dx%d.%s",
            $this->protocol,
            $this->host,
            $this->id,
            $width ?: $this->width,
            $height ?: $this->height,
            $ext ?? $this->ext
        );
        return new self($uri);
    }

    public function __toString(): string
    {
        return $this->uri;
    }
}