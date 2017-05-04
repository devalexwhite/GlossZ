<?php

use Phinx\Migration\AbstractMigration;

class SampleData extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $users = [
            [
                'username' => 'devalexwhite',
                'email' => 'devalexwhite@gmail.com',
                'password' => 'test'
            ]
        ];

        $this->table('user')->insert($users)->save();

        $glossaries = [
            [
                'title' => 'Sample glossary 1',
                'user_id' => 1
            ]
        ];

        $this->table('glossary')->insert($glossaries)->save();

        $terms = [
            [
                'value' => 'Sushi',
                'glossary_id' => 1,
                'user_id' => 1
            ],
            [
                'value' => 'Taco',
                'glossary_id' => 1,
                'user_id' => 1
            ],
            [
                'value' => 'Job',
                'glossary_id' => 1,
                'user_id' => 1
            ]
        ];

        $this->table('term')->insert($terms)->save();

        $languages = [
            [
            "short_name" => "abk",
            "full_name" => "Abkhazian"
            ],
            [
            "short_name" => "ace",
            "full_name" => "Achinese"
            ],
            [
            "short_name" => "ach",
            "full_name" => "Acoli"
            ],
            [
            "short_name" => "ada",
            "full_name" => "Adangme"
            ],
            [
            "short_name" => "aar",
            "full_name" => "Afar"
            ],
            [
            "short_name" => "afh",
            "full_name" => "Afrihili"
            ],
            [
            "short_name" => "afr",
            "full_name" => "Afrikaans"
            ],
            [
            "short_name" => "afa",
            "full_name" => "Afro-Asiatic (Other)"
            ],
            [
            "short_name" => "aka",
            "full_name" => "Akan"
            ],
            [
            "short_name" => "akk",
            "full_name" => "Akkadian"
            ],
            [
            "short_name" => "alb",
            "full_name" => "Albanian"
            ],
            [
            "short_name" => "ale",
            "full_name" => "Aleut"
            ],
            [
            "short_name" => "alg",
            "full_name" => "Algonquian languages"
            ],
            [
            "short_name" => "tut",
            "full_name" => "Altaic languages"
            ],
            [
            "short_name" => "amh",
            "full_name" => "Amharic"
            ],
            [
            "short_name" => "hbo",
            "full_name" => "Ancient Hebrew"
            ],
            [
            "short_name" => "apa",
            "full_name" => "Apache languages"
            ],
            [
            "short_name" => "ara",
            "full_name" => "Arabic"
            ],
            [
            "short_name" => "arc",
            "full_name" => "Aramaic"
            ],
            [
            "short_name" => "arp",
            "full_name" => "Arapaho"
            ],
            [
            "short_name" => "arn",
            "full_name" => "Araucanian"
            ],
            [
            "short_name" => "arw",
            "full_name" => "Arawak"
            ],
            [
            "short_name" => "arm",
            "full_name" => "Armenian"
            ],
            [
            "short_name" => "art",
            "full_name" => "Artificial(Other)"
            ],
            [
            "short_name" => "asm",
            "full_name" => "Assamese"
            ],
            [
            "short_name" => "ast",
            "full_name" => "Asturian"
            ],
            [
            "short_name" => "ath",
            "full_name" => "Athapascan languages"
            ],
            [
            "short_name" => "map",
            "full_name" => "Austronesian(Other)"
            ],
            [
            "short_name" => "ava",
            "full_name" => "Avaric"
            ],
            [
            "short_name" => "ave",
            "full_name" => "Avestan"
            ],
            [
            "short_name" => "awa",
            "full_name" => "Awadhi"
            ],
            [
            "short_name" => "aym",
            "full_name" => "Aymara"
            ],
            [
            "short_name" => "aze",
            "full_name" => "Azerbaijani"
            ],
            [
            "short_name" => "bba",
            "full_name" => "Baatonum"
            ],
            [
            "short_name" => "ban",
            "full_name" => "Balinese"
            ],
            [
            "short_name" => "bat",
            "full_name" => "Baltic languages"
            ],
            [
            "short_name" => "bal",
            "full_name" => "Baluchi"
            ],
            [
            "short_name" => "bam",
            "full_name" => "Bambara"
            ],
            [
            "short_name" => "bai",
            "full_name" => "Bamilekelanguages"
            ],
            [
            "short_name" => "bad",
            "full_name" => "Banda"
            ],
            [
            "short_name" => "bnt",
            "full_name" => "Bantu(Other)"
            ],
            [
            "short_name" => "bas",
            "full_name" => "Basa"
            ],
            [
            "short_name" => "bak",
            "full_name" => "Bashkir"
            ],
            [
            "short_name" => "baq",
            "full_name" => "Basque"
            ],
            [
            "short_name" => "bej",
            "full_name" => "Beja"
            ],
            [
            "short_name" => "bel",
            "full_name" => "Belarusian"
            ],
            [
            "short_name" => "bem",
            "full_name" => "Bemba"
            ],
            [
            "short_name" => "ben",
            "full_name" => "Bengali"
            ],
            [
            "short_name" => "ber",
            "full_name" => "Berber (Other)"
            ],
            [
            "short_name" => "bho",
            "full_name" => "Bhojpuri (&amp; Tharu)"
            ],
            [
            "short_name" => "bih",
            "full_name" => "Bihari"
            ],
            [
            "short_name" => "bik",
            "full_name" => "Bikol"
            ],
            [
            "short_name" => "bin",
            "full_name" => "Bini"
            ],
            [
            "short_name" => "bis",
            "full_name" => "Bislama"
            ],
            [
            "short_name" => ".bo",
            "full_name" => "Bosnian"
            ],
            [
            "short_name" => ".br",
            "full_name" => "Brahui"
            ],
            [
            "short_name" => "bra",
            "full_name" => "Braj"
            ],
            [
            "short_name" => "bre",
            "full_name" => "Breton"
            ],
            [
            "short_name" => "bug",
            "full_name" => "Buginese"
            ],
            [
            "short_name" => "bul",
            "full_name" => "Bulgarian"
            ],
            [
            "short_name" => "bua",
            "full_name" => "Buriat"
            ],
            [
            "short_name" => "bur",
            "full_name" => "Burmese"
            ],
            [
            "short_name" => "cad",
            "full_name" => "Caddo"
            ],
            [
            "short_name" => "car",
            "full_name" => "Carib"
            ],
            [
            "short_name" => "cat",
            "full_name" => "Catalan"
            ],
            [
            "short_name" => "cau",
            "full_name" => "Caucasian(Other)"
            ],
            [
            "short_name" => "ceb",
            "full_name" => "Cebuano (Bisayan)"
            ],
            [
            "short_name" => "cel",
            "full_name" => "Celtic(Other)"
            ],
            [
            "short_name" => "cai",
            "full_name" => "Central American Indian (Other)"
            ],
            [
            "short_name" => "chg",
            "full_name" => "Chagatai"
            ],
            [
            "short_name" => ".cm",
            "full_name" => "Cham"
            ],
            [
            "short_name" => "cha",
            "full_name" => "Chamorro"
            ],
            [
            "short_name" => "che",
            "full_name" => "Chechen"
            ],
            [
            "short_name" => "chr",
            "full_name" => "Cherokee"
            ],
            [
            "short_name" => "chy",
            "full_name" => "Cheyenne"
            ],
            [
            "short_name" => "chb",
            "full_name" => "Chibcha"
            ],
            [
            "short_name" => ".ci",
            "full_name" => "Chin"
            ],
            [
            "short_name" => "chi",
            "full_name" => "Chinese"
            ],
            [
            "short_name" => "chn",
            "full_name" => "Chinookjargon"
            ],
            [
            "short_name" => "cho",
            "full_name" => "Choctaw"
            ],
            [
            "short_name" => "chu",
            "full_name" => "Church Slavonic"
            ],
            [
            "short_name" => "chk",
            "full_name" => "Chuukese"
            ],
            [
            "short_name" => "chv",
            "full_name" => "Chuvash"
            ],
            [
            "short_name" => ".im",
            "full_name" => "Cook Island Maori"
            ],
            [
            "short_name" => "cop",
            "full_name" => "Coptic"
            ],
            [
            "short_name" => "cor",
            "full_name" => "Cornish"
            ],
            [
            "short_name" => "cos",
            "full_name" => "Corsican"
            ],
            [
            "short_name" => "cre",
            "full_name" => "Cree"
            ],
            [
            "short_name" => "mus",
            "full_name" => "Creek"
            ],
            [
            "short_name" => "cpe",
            "full_name" => "Creoles &amp; Pidgins (English-based Other)"
            ],
            [
            "short_name" => "cpf",
            "full_name" => "Creoles &amp; Pidgins (French-based Other)"
            ],
            [
            "short_name" => "crp",
            "full_name" => "Creoles &amp; Pidgins (Other)"
            ],
            [
            "short_name" => "cpp",
            "full_name" => "Creoles &amp; Pidgins (Portuguese-based Other)"
            ],
            [
            "short_name" => ".cr",
            "full_name" => "Croatian"
            ],
            [
            "short_name" => "cus",
            "full_name" => "Cushitic(Other)"
            ],
            [
            "short_name" => "ces",
            "full_name" => "Czech"
            ],
            [
            "short_name" => "dag",
            "full_name" => "Dagbani"
            ],
            [
            "short_name" => "dak",
            "full_name" => "Dakota"
            ],
            [
            "short_name" => ".dm",
            "full_name" => "Damara"
            ],
            [
            "short_name" => "dan",
            "full_name" => "Danish"
            ],
            [
            "short_name" => ".dr",
            "full_name" => "Dari"
            ],
            [
            "short_name" => ".dy",
            "full_name" => "Dayak"
            ],
            [
            "short_name" => "del",
            "full_name" => "Delaware"
            ],
            [
            "short_name" => ".dd",
            "full_name" => "Dida"
            ],
            [
            "short_name" => "din",
            "full_name" => "Dinka"
            ],
            [
            "short_name" => "div",
            "full_name" => "Divehi"
            ],
            [
            "short_name" => "doi",
            "full_name" => "Dogri"
            ],
            [
            "short_name" => "dra",
            "full_name" => "Dravidian(Other)"
            ],
            [
            "short_name" => "dua",
            "full_name" => "Duala"
            ],
            [
            "short_name" => "dut",
            "full_name" => "Dutch"
            ],
            [
            "short_name" => "dum",
            "full_name" => "Dutch Middle (ca.1050-1350)"
            ],
            [
            "short_name" => "dyu",
            "full_name" => "Dyula"
            ],
            [
            "short_name" => "dzo",
            "full_name" => "Dzongkha"
            ],
            [
            "short_name" => "efi",
            "full_name" => "Efik"
            ],
            [
            "short_name" => "egy",
            "full_name" => "Egyptian(Ancient)"
            ],
            [
            "short_name" => "eka",
            "full_name" => "Ekajuk"
            ],
            [
            "short_name" => "elx",
            "full_name" => "Elamite"
            ],
            [
            "short_name" => "eng",
            "full_name" => "English"
            ],
            [
            "short_name" => "enm",
            "full_name" => "English Middle (ca.1100-1500)"
            ],
            [
            "short_name" => "ang",
            "full_name" => "English Old (ca.450-1100)"
            ],
            [
            "short_name" => "esk",
            "full_name" => "Eskimo(Other)"
            ],
            [
            "short_name" => "epo",
            "full_name" => "Esperanto"
            ],
            [
            "short_name" => "est",
            "full_name" => "Estonian"
            ],
            [
            "short_name" => "ewe",
            "full_name" => "Ewe"
            ],
            [
            "short_name" => "ewo",
            "full_name" => "Ewondo"
            ],
            [
            "short_name" => "fng",
            "full_name" => "Fanagalo"
            ],
            [
            "short_name" => "fan",
            "full_name" => "Fang"
            ],
            [
            "short_name" => "fat",
            "full_name" => "Fanti (Fante)"
            ],
            [
            "short_name" => "fao",
            "full_name" => "Faroese"
            ],
            [
            "short_name" => ".fs",
            "full_name" => "Farsi (Persian)"
            ],
            [
            "short_name" => "fij",
            "full_name" => "Fijian"
            ],
            [
            "short_name" => "fin",
            "full_name" => "Finnish"
            ],
            [
            "short_name" => "fiu",
            "full_name" => "Finno-Ugrian(Other)"
            ],
            [
            "short_name" => ".fl",
            "full_name" => "Flemish"
            ],
            [
            "short_name" => "fon",
            "full_name" => "Fon"
            ],
            [
            "short_name" => ".fw",
            "full_name" => "Formosan"
            ],
            [
            "short_name" => "fra",
            "full_name" => "French"
            ],
            [
            "short_name" => "frm",
            "full_name" => "French Middle (ca.1400-1600)"
            ],
            [
            "short_name" => "fro",
            "full_name" => "French Old (842-ca.1400)"
            ],
            [
            "short_name" => "fry",
            "full_name" => "Frisian"
            ],
            [
            "short_name" => "fur",
            "full_name" => "Friulian"
            ],
            [
            "short_name" => "ful",
            "full_name" => "Fulah"
            ],
            [
            "short_name" => ".fu",
            "full_name" => "Fulani"
            ],
            [
            "short_name" => "gaa",
            "full_name" => "Ga"
            ],
            [
            "short_name" => "gae",
            "full_name" => "Gaelic"
            ],
            [
            "short_name" => "glg",
            "full_name" => "Galician"
            ],
            [
            "short_name" => "lug",
            "full_name" => "Ganda"
            ],
            [
            "short_name" => "gay",
            "full_name" => "Gayo"
            ],
            [
            "short_name" => "gez",
            "full_name" => "Geez"
            ],
            [
            "short_name" => "geo",
            "full_name" => "Georgian"
            ],
            [
            "short_name" => "deu",
            "full_name" => "German"
            ],
            [
            "short_name" => "gem",
            "full_name" => "Germanic(Other)"
            ],
            [
            "short_name" => "gmh",
            "full_name" => "German Middle High (ca.1050-1500)"
            ],
            [
            "short_name" => "goh",
            "full_name" => "German Old High (ca.750-1050)"
            ],
            [
            "short_name" => "gil",
            "full_name" => "Gilbertese"
            ],
            [
            "short_name" => "gon",
            "full_name" => "Gondi"
            ],
            [
            "short_name" => "got",
            "full_name" => "Gothic"
            ],
            [
            "short_name" => "grb",
            "full_name" => "Grebo"
            ],
            [
            "short_name" => "ell",
            "full_name" => "Greek"
            ],
            [
            "short_name" => "grc",
            "full_name" => "Greek (Ancient)"
            ],
            [
            "short_name" => "kal",
            "full_name" => "Greenlandic / Kalaallisut"
            ],
            [
            "short_name" => "grn",
            "full_name" => "Guarani"
            ],
            [
            "short_name" => "guj",
            "full_name" => "Gujarati"
            ],
            [
            "short_name" => "hai",
            "full_name" => "Haida"
            ],
            [
            "short_name" => ".hc",
            "full_name" => "Haitian-Creole"
            ],
            [
            "short_name" => "hau",
            "full_name" => "Hausa"
            ],
            [
            "short_name" => "haw",
            "full_name" => "Hawaiian"
            ],
            [
            "short_name" => "heb",
            "full_name" => "Hebrew"
            ],
            [
            "short_name" => "her",
            "full_name" => "Herero"
            ],
            [
            "short_name" => "hil",
            "full_name" => "Hiligaynon"
            ],
            [
            "short_name" => "him",
            "full_name" => "Himachali"
            ],
            [
            "short_name" => "hin",
            "full_name" => "Hindi"
            ],
            [
            "short_name" => "hmo",
            "full_name" => "HiriMotu"
            ],
            [
            "short_name" => ".hm",
            "full_name" => "Hmong"
            ],
            [
            "short_name" => "hun",
            "full_name" => "Hungarian"
            ],
            [
            "short_name" => "hup",
            "full_name" => "Hupa"
            ],
            [
            "short_name" => ".ik",
            "full_name" => "I-kiribati"
            ],
            [
            "short_name" => "iba",
            "full_name" => "Iban"
            ],
            [
            "short_name" => "ice",
            "full_name" => "Icelandic"
            ],
            [
            "short_name" => "ibo",
            "full_name" => "Igbo"
            ],
            [
            "short_name" => "ijo",
            "full_name" => "Ijo"
            ],
            [
            "short_name" => "ilo",
            "full_name" => "Iloko"
            ],
            [
            "short_name" => "inc",
            "full_name" => "Indic(Other)"
            ],
            [
            "short_name" => "ine",
            "full_name" => "Indo-European(Other)"
            ],
            [
            "short_name" => "ind",
            "full_name" => "Indonesian"
            ],
            [
            "short_name" => "inh",
            "full_name" => "Ingush"
            ],
            [
            "short_name" => "ina",
            "full_name" => "Interlingua"
            ],
            [
            "short_name" => "ile",
            "full_name" => "Interlingue"
            ],
            [
            "short_name" => "iku",
            "full_name" => "Inuktitut"
            ],
            [
            "short_name" => "ipk",
            "full_name" => "Inupiak"
            ],
            [
            "short_name" => "ira",
            "full_name" => "Iranian(Other)"
            ],
            [
            "short_name" => "gai",
            "full_name" => "Irish"
            ],
            [
            "short_name" => "mga",
            "full_name" => "Irish Middle (900-1200)"
            ],
            [
            "short_name" => "sga",
            "full_name" => "Irish Old (to 900)"
            ],
            [
            "short_name" => "iro",
            "full_name" => "Iroquoian Languages"
            ],
            [
            "short_name" => "ita",
            "full_name" => "Italian"
            ],
            [
            "short_name" => "ijc",
            "full_name" => "Izon"
            ],
            [
            "short_name" => "jpn",
            "full_name" => "Japanese"
            ],
            [
            "short_name" => "jav",
            "full_name" => "Javanese"
            ],
            [
            "short_name" => "jrb",
            "full_name" => "Judeo-Arabic"
            ],
            [
            "short_name" => "jpr",
            "full_name" => "Judeo-Persian"
            ],
            [
            "short_name" => "quc",
            "full_name" => "K'iche'"
            ],
            [
            "short_name" => "kab",
            "full_name" => "Kabyle"
            ],
            [
            "short_name" => "kac",
            "full_name" => "Kachin"
            ],
            [
            "short_name" => ".kd",
            "full_name" => "Kadazan"
            ],
            [
            "short_name" => "ijn",
            "full_name" => "Kalabari"
            ],
            [
            "short_name" => "xal",
            "full_name" => "Kalmyk-Oirat"
            ],
            [
            "short_name" => "kam",
            "full_name" => "Kamba"
            ],
            [
            "short_name" => "kan",
            "full_name" => "Kannada"
            ],
            [
            "short_name" => "kau",
            "full_name" => "Kanuri"
            ],
            [
            "short_name" => "kaa",
            "full_name" => "Kara-Kalpak"
            ],
            [
            "short_name" => "kar",
            "full_name" => "Karen"
            ],
            [
            "short_name" => "kas",
            "full_name" => "Kashmiri"
            ],
            [
            "short_name" => "csb",
            "full_name" => "Kashubian"
            ],
            [
            "short_name" => "kaw",
            "full_name" => "Kawi"
            ],
            [
            "short_name" => ".ky",
            "full_name" => "Kayah"
            ],
            [
            "short_name" => "kaz",
            "full_name" => "Kazakh"
            ],
            [
            "short_name" => "kha",
            "full_name" => "Khasi"
            ],
            [
            "short_name" => "khm",
            "full_name" => "Khmer (Central)"
            ],
            [
            "short_name" => "khi",
            "full_name" => "Khoisan(Other)"
            ],
            [
            "short_name" => "kho",
            "full_name" => "Khotanese"
            ],
            [
            "short_name" => "kik",
            "full_name" => "Kikuyu"
            ],
            [
            "short_name" => "kin",
            "full_name" => "Kinyarwanda"
            ],
            [
            "short_name" => "kir",
            "full_name" => "Kirghiz"
            ],
            [
            "short_name" => ".kl",
            "full_name" => "Klingon"
            ],
            [
            "short_name" => "kom",
            "full_name" => "Komi"
            ],
            [
            "short_name" => "kon",
            "full_name" => "Kongo"
            ],
            [
            "short_name" => "kok",
            "full_name" => "Konkani"
            ],
            [
            "short_name" => "kor",
            "full_name" => "Korean"
            ],
            [
            "short_name" => "kos",
            "full_name" => "Kosraean"
            ],
            [
            "short_name" => "kpe",
            "full_name" => "Kpelle"
            ],
            [
            "short_name" => "kri",
            "full_name" => "Krio"
            ],
            [
            "short_name" => "kro",
            "full_name" => "Kru"
            ],
            [
            "short_name" => "kua",
            "full_name" => "Kuanyama"
            ],
            [
            "short_name" => "kum",
            "full_name" => "Kumyk"
            ],
            [
            "short_name" => "kur",
            "full_name" => "Kurdish"
            ],
            [
            "short_name" => "kru",
            "full_name" => "Kurukh"
            ],
            [
            "short_name" => "kus",
            "full_name" => "Kusaie"
            ],
            [
            "short_name" => "kut",
            "full_name" => "Kutenai"
            ],
            [
            "short_name" => "lad",
            "full_name" => "Ladino"
            ],
            [
            "short_name" => "lah",
            "full_name" => "Lahnda"
            ],
            [
            "short_name" => "lam",
            "full_name" => "Lamba"
            ],
            [
            "short_name" => "lao",
            "full_name" => "Lao"
            ],
            [
            "short_name" => "lat",
            "full_name" => "Latin"
            ],
            [
            "short_name" => "lav",
            "full_name" => "Latvian"
            ],
            [
            "short_name" => "ltz",
            "full_name" => "Letzeburgesch"
            ],
            [
            "short_name" => "lez",
            "full_name" => "Lezghian"
            ],
            [
            "short_name" => "lin",
            "full_name" => "Lingala"
            ],
            [
            "short_name" => "lit",
            "full_name" => "Lithuanian"
            ],
            [
            "short_name" => "lom",
            "full_name" => "Loma"
            ],
            [
            "short_name" => "loz",
            "full_name" => "Lozi"
            ],
            [
            "short_name" => "lub",
            "full_name" => "Luba-Katanga"
            ],
            [
            "short_name" => "lui",
            "full_name" => "Luiseno"
            ],
            [
            "short_name" => "lun",
            "full_name" => "Lunda"
            ],
            [
            "short_name" => "luo",
            "full_name" => "Luo (Kenya"
            ],
            [
            "short_name" => "lus",
            "full_name" => "Lushai (Mizo)"
            ],
            [
            "short_name" => "ymm",
            "full_name" => "Maay Maay"
            ],
            [
            "short_name" => "mac",
            "full_name" => "Macedonian"
            ],
            [
            "short_name" => "mad",
            "full_name" => "Madurese"
            ],
            [
            "short_name" => "mag",
            "full_name" => "Magahi"
            ],
            [
            "short_name" => "mai",
            "full_name" => "Maithili"
            ],
            [
            "short_name" => "mak",
            "full_name" => "Makasar"
            ],
            [
            "short_name" => "mlg",
            "full_name" => "Malagasy"
            ],
            [
            "short_name" => "may",
            "full_name" => "Malay"
            ],
            [
            "short_name" => "mal",
            "full_name" => "Malayalam"
            ],
            [
            "short_name" => "mlt",
            "full_name" => "Maltese"
            ],
            [
            "short_name" => "xmm",
            "full_name" => "Manado Malay"
            ],
            [
            "short_name" => "man",
            "full_name" => "Mandingo"
            ],
            [
            "short_name" => "mni",
            "full_name" => "Manipuri"
            ],
            [
            "short_name" => "mno",
            "full_name" => "Manobolanguages"
            ],
            [
            "short_name" => "max",
            "full_name" => "Manx"
            ],
            [
            "short_name" => "mao",
            "full_name" => "Maori"
            ],
            [
            "short_name" => "mar",
            "full_name" => "Marathi"
            ],
            [
            "short_name" => "chm",
            "full_name" => "Mari"
            ],
            [
            "short_name" => "mah",
            "full_name" => "Marshallese"
            ],
            [
            "short_name" => "mwr",
            "full_name" => "Marwari"
            ],
            [
            "short_name" => "mas",
            "full_name" => "Masai"
            ],
            [
            "short_name" => "myn",
            "full_name" => "Mayanlanguages"
            ],
            [
            "short_name" => ".mb",
            "full_name" => "Mbundu"
            ],
            [
            "short_name" => "men",
            "full_name" => "Mende"
            ],
            [
            "short_name" => ".me",
            "full_name" => "Meo"
            ],
            [
            "short_name" => ".mi",
            "full_name" => "Miao"
            ],
            [
            "short_name" => "mic",
            "full_name" => "Micmac"
            ],
            [
            "short_name" => "min",
            "full_name" => "Minangkabau"
            ],
            [
            "short_name" => "mks",
            "full_name" => "Mixteco"
            ],
            [
            "short_name" => "moh",
            "full_name" => "Mohawk"
            ],
            [
            "short_name" => "mol",
            "full_name" => "Moldavian"
            ],
            [
            "short_name" => "mkh",
            "full_name" => "Mon-Khmer(Other)"
            ],
            [
            "short_name" => "lol",
            "full_name" => "Mongo"
            ],
            [
            "short_name" => "mon",
            "full_name" => "Mongolian"
            ],
            [
            "short_name" => "srp",
            "full_name" => "Montenegrin"
            ],
            [
            "short_name" => ".mk",
            "full_name" => "Mordvinian"
            ],
            [
            "short_name" => "mos",
            "full_name" => "Mossi"
            ],
            [
            "short_name" => "mun",
            "full_name" => "Mundalanguages"
            ],
            [
            "short_name" => ".mu",
            "full_name" => "Muong"
            ],
            [
            "short_name" => "nah",
            "full_name" => "Nahuatl (Aztec)"
            ],
            [
            "short_name" => "nau",
            "full_name" => "Nauru"
            ],
            [
            "short_name" => "nav",
            "full_name" => "Navajo"
            ],
            [
            "short_name" => "nde",
            "full_name" => "NdebeleNorth"
            ],
            [
            "short_name" => "nbl",
            "full_name" => "NdebeleSouth"
            ],
            [
            "short_name" => "ndo",
            "full_name" => "Ndongo"
            ],
            [
            "short_name" => "nep",
            "full_name" => "Nepali"
            ],
            [
            "short_name" => "new",
            "full_name" => "Newari"
            ],
            [
            "short_name" => "nic",
            "full_name" => "Niger-Kordofanian(Other)"
            ],
            [
            "short_name" => ".ni",
            "full_name" => "Nigerian"
            ],
            [
            "short_name" => "ssa",
            "full_name" => "Nilo-Saharan(Other)"
            ],
            [
            "short_name" => "niu",
            "full_name" => "Niuean"
            ],
            [
            "short_name" => "non",
            "full_name" => "Norse"
            ],
            [
            "short_name" => "nai",
            "full_name" => "NorthAmericanIndian(Other)"
            ],
            [
            "short_name" => "nor",
            "full_name" => "Norwegian"
            ],
            [
            "short_name" => "nob",
            "full_name" => "Norwegian (Bokmal)"
            ],
            [
            "short_name" => "nno",
            "full_name" => "Norwegian (Nynorsk)"
            ],
            [
            "short_name" => "nub",
            "full_name" => "Nubianlanguages"
            ],
            [
            "short_name" => "nym",
            "full_name" => "Nyamwezi"
            ],
            [
            "short_name" => "nya",
            "full_name" => "Nyanja"
            ],
            [
            "short_name" => "nyn",
            "full_name" => "Nyankole"
            ],
            [
            "short_name" => "nyo",
            "full_name" => "Nyoro"
            ],
            [
            "short_name" => "nzi",
            "full_name" => "Nzima"
            ],
            [
            "short_name" => "oci",
            "full_name" => "Occitan / Langued'Oc"
            ],
            [
            "short_name" => "oji",
            "full_name" => "Ojibwe"
            ],
            [
            "short_name" => "ori",
            "full_name" => "Oriya"
            ],
            [
            "short_name" => "orm",
            "full_name" => "Oromo"
            ],
            [
            "short_name" => "osa",
            "full_name" => "Osage"
            ],
            [
            "short_name" => "oss",
            "full_name" => "Ossetic"
            ],
            [
            "short_name" => "oto",
            "full_name" => "Otomianlanguages"
            ],
            [
            "short_name" => "ota",
            "full_name" => "Ottoman"
            ],
            [
            "short_name" => ".ov",
            "full_name" => "Ovambo"
            ],
            [
            "short_name" => "pal",
            "full_name" => "Pahlavi"
            ],
            [
            "short_name" => "pau",
            "full_name" => "Palauan"
            ],
            [
            "short_name" => "pli",
            "full_name" => "Pali"
            ],
            [
            "short_name" => "pam",
            "full_name" => "Pampanga"
            ],
            [
            "short_name" => "pag",
            "full_name" => "Pangasinan"
            ],
            [
            "short_name" => "pan",
            "full_name" => "Panjabi"
            ],
            [
            "short_name" => "pap",
            "full_name" => "Papiamento"
            ],
            [
            "short_name" => "paa",
            "full_name" => "Papuan-Australian(Other)"
            ],
            [
            "short_name" => "pus",
            "full_name" => "Pashto (Pushto)"
            ],
            [
            "short_name" => "fas",
            "full_name" => "Persian (Farsi)"
            ],
            [
            "short_name" => "peo",
            "full_name" => "PersianOld(ca600-400B.C.)"
            ],
            [
            "short_name" => "phn",
            "full_name" => "Phoenician"
            ],
            [
            "short_name" => "pon",
            "full_name" => "Pohnpeian"
            ],
            [
            "short_name" => "pol",
            "full_name" => "Polish"
            ],
            [
            "short_name" => "por",
            "full_name" => "Portuguese"
            ],
            [
            "short_name" => "pra",
            "full_name" => "Prakritlanguages"
            ],
            [
            "short_name" => "pro",
            "full_name" => "ProvencalOld(to1500)"
            ],
            [
            "short_name" => "kek",
            "full_name" => "Q'eqchi' / Kekchi"
            ],
            [
            "short_name" => "que",
            "full_name" => "Quechua"
            ],
            [
            "short_name" => "raj",
            "full_name" => "Rajasthani"
            ],
            [
            "short_name" => "rar",
            "full_name" => "Rarotongan"
            ],
            [
            "short_name" => "roh",
            "full_name" => "Rhaeto-Rom (Romansch)"
            ],
            [
            "short_name" => "roa",
            "full_name" => "Romance(Other)"
            ],
            [
            "short_name" => "ron",
            "full_name" => "Romanian"
            ],
            [
            "short_name" => "rom",
            "full_name" => "Romany"
            ],
            [
            "short_name" => "run",
            "full_name" => "Rundi"
            ],
            [
            "short_name" => "rus",
            "full_name" => "Russian"
            ],
            [
            "short_name" => "sal",
            "full_name" => "Salishanlanguages"
            ],
            [
            "short_name" => "sam",
            "full_name" => "SamaritanAramaic"
            ],
            [
            "short_name" => "smi",
            "full_name" => "Samilanguages"
            ],
            [
            "short_name" => "smo",
            "full_name" => "Samoan"
            ],
            [
            "short_name" => "sad",
            "full_name" => "Sandawe"
            ],
            [
            "short_name" => "sag",
            "full_name" => "Sango"
            ],
            [
            "short_name" => "san",
            "full_name" => "Sanskrit"
            ],
            [
            "short_name" => "srd",
            "full_name" => "Sardinian"
            ],
            [
            "short_name" => "sco",
            "full_name" => "Scots"
            ],
            [
            "short_name" => "gla",
            "full_name" => "Scottish Gaelic"
            ],
            [
            "short_name" => "sel",
            "full_name" => "Selkup"
            ],
            [
            "short_name" => "sem",
            "full_name" => "Semitic(Other)"
            ],
            [
            "short_name" => "...",
            "full_name" => "Serbian"
            ],
            [
            "short_name" => "scr",
            "full_name" => "Serbo-Croat"
            ],
            [
            "short_name" => "srr",
            "full_name" => "Serer"
            ],
            [
            "short_name" => "shn",
            "full_name" => "Shan"
            ],
            [
            "short_name" => "sna",
            "full_name" => "Shona"
            ],
            [
            "short_name" => "scn",
            "full_name" => "Sicilian"
            ],
            [
            "short_name" => "sid",
            "full_name" => "Sidamo"
            ],
            [
            "short_name" => ".sg",
            "full_name" => "Sign Language"
            ],
            [
            "short_name" => "bla",
            "full_name" => "Siksika"
            ],
            [
            "short_name" => ".se",
            "full_name" => "Simple English"
            ],
            [
            "short_name" => "snd",
            "full_name" => "Sindhi"
            ],
            [
            "short_name" => "sin",
            "full_name" => "Sinhala (Sinhalese)"
            ],
            [
            "short_name" => "sit",
            "full_name" => "Sino-Tibetan"
            ],
            [
            "short_name" => "sio",
            "full_name" => "Siouanlanguages"
            ],
            [
            "short_name" => "ssw",
            "full_name" => "Siswant"
            ],
            [
            "short_name" => ".ss",
            "full_name" => "SiSwati (Swazi)"
            ],
            [
            "short_name" => "sla",
            "full_name" => "Slavic(Other)"
            ],
            [
            "short_name" => "slk",
            "full_name" => "Slovak"
            ],
            [
            "short_name" => "slv",
            "full_name" => "Slovenian"
            ],
            [
            "short_name" => "sog",
            "full_name" => "Sogdian"
            ],
            [
            "short_name" => "som",
            "full_name" => "Somali"
            ],
            [
            "short_name" => ".sx",
            "full_name" => "Somba"
            ],
            [
            "short_name" => "son",
            "full_name" => "Songhai"
            ],
            [
            "short_name" => "wen",
            "full_name" => "Sorbian"
            ],
            [
            "short_name" => "nso",
            "full_name" => "SothoNorthern"
            ],
            [
            "short_name" => "sai",
            "full_name" => "SouthAmericanIndian(Other)"
            ],
            [
            "short_name" => "sot",
            "full_name" => "Southern Sotho / Sesotho"
            ],
            [
            "short_name" => "esl",
            "full_name" => "Spanish"
            ],
            [
            "short_name" => "suk",
            "full_name" => "Sukuma"
            ],
            [
            "short_name" => "sux",
            "full_name" => "Sumerian"
            ],
            [
            "short_name" => "sun",
            "full_name" => "Sundanese"
            ],
            [
            "short_name" => "sus",
            "full_name" => "Susu"
            ],
            [
            "short_name" => "swa",
            "full_name" => "Swahili"
            ],
            [
            "short_name" => "sve",
            "full_name" => "Swedish"
            ],
            [
            "short_name" => "syl",
            "full_name" => "Sylheti"
            ],
            [
            "short_name" => "syr",
            "full_name" => "Syriac"
            ],
            [
            "short_name" => "tgl",
            "full_name" => "Tagalog"
            ],
            [
            "short_name" => "tah",
            "full_name" => "Tahitian"
            ],
            [
            "short_name" => "tgk",
            "full_name" => "Tajik"
            ],
            [
            "short_name" => ".tm",
            "full_name" => "Tamang"
            ],
            [
            "short_name" => "tmh",
            "full_name" => "Tamashek"
            ],
            [
            "short_name" => "tam",
            "full_name" => "Tamil"
            ],
            [
            "short_name" => "tat",
            "full_name" => "Tatar"
            ],
            [
            "short_name" => "tel",
            "full_name" => "Telugu"
            ],
            [
            "short_name" => "ter",
            "full_name" => "Tereno"
            ],
            [
            "short_name" => "tet",
            "full_name" => "Tetum"
            ],
            [
            "short_name" => "tha",
            "full_name" => "Thai"
            ],
            [
            "short_name" => "bod",
            "full_name" => "Tibetan"
            ],
            [
            "short_name" => "tig",
            "full_name" => "Tigre"
            ],
            [
            "short_name" => "tir",
            "full_name" => "Tigrinya"
            ],
            [
            "short_name" => "tem",
            "full_name" => "Timne"
            ],
            [
            "short_name" => "tiv",
            "full_name" => "Tivi"
            ],
            [
            "short_name" => "tli",
            "full_name" => "Tlingit"
            ],
            [
            "short_name" => "tpi",
            "full_name" => "Tok Pisin"
            ],
            [
            "short_name" => "tog",
            "full_name" => "Tonga (Nya)"
            ],
            [
            "short_name" => "ton",
            "full_name" => "Tonga(TongaIslands)"
            ],
            [
            "short_name" => "tru",
            "full_name" => "Truk"
            ],
            [
            "short_name" => "tsi",
            "full_name" => "Tsimshian"
            ],
            [
            "short_name" => "tso",
            "full_name" => "Tsonga"
            ],
            [
            "short_name" => "tsn",
            "full_name" => "Tswana"
            ],
            [
            "short_name" => "tum",
            "full_name" => "Tumbuka"
            ],
            [
            "short_name" => "tur",
            "full_name" => "Turkish"
            ],
            [
            "short_name" => "tuk",
            "full_name" => "Turkmen"
            ],
            [
            "short_name" => ".tv",
            "full_name" => "Tuvaluan"
            ],
            [
            "short_name" => "tyv",
            "full_name" => "Tuvinian"
            ],
            [
            "short_name" => "twi",
            "full_name" => "Twi"
            ],
            [
            "short_name" => "uga",
            "full_name" => "Ugaritic"
            ],
            [
            "short_name" => "uig",
            "full_name" => "Uighur"
            ],
            [
            "short_name" => "ukr",
            "full_name" => "Ukrainian"
            ],
            [
            "short_name" => ".yq",
            "full_name" => "Ulithian"
            ],
            [
            "short_name" => "umb",
            "full_name" => "Umbundu"
            ],
            [
            "short_name" => "urd",
            "full_name" => "Urdu"
            ],
            [
            "short_name" => "uzb",
            "full_name" => "Uzbek"
            ],
            [
            "short_name" => "vai",
            "full_name" => "Vai"
            ],
            [
            "short_name" => ".va",
            "full_name" => "Valencia"
            ],
            [
            "short_name" => "ven",
            "full_name" => "Venda"
            ],
            [
            "short_name" => "vie",
            "full_name" => "Vietnamese"
            ],
            [
            "short_name" => "vol",
            "full_name" => "Volapük"
            ],
            [
            "short_name" => "vot",
            "full_name" => "Votic"
            ],
            [
            "short_name" => "wak",
            "full_name" => "Wakashanlanguages"
            ],
            [
            "short_name" => "wal",
            "full_name" => "Walamo"
            ],
            [
            "short_name" => "war",
            "full_name" => "Waray"
            ],
            [
            "short_name" => "was",
            "full_name" => "Washo"
            ],
            [
            "short_name" => "cym",
            "full_name" => "Welsh"
            ],
            [
            "short_name" => ".ys",
            "full_name" => "Woleaian"
            ],
            [
            "short_name" => "wol",
            "full_name" => "Wolof"
            ],
            [
            "short_name" => "xho",
            "full_name" => "Xhosa"
            ],
            [
            "short_name" => "sah",
            "full_name" => "Yakut"
            ],
            [
            "short_name" => "yao",
            "full_name" => "Yao"
            ],
            [
            "short_name" => "yap",
            "full_name" => "Yapese"
            ],
            [
            "short_name" => ".yi",
            "full_name" => "Yi"
            ],
            [
            "short_name" => "yid",
            "full_name" => "Yiddish"
            ],
            [
            "short_name" => "yor",
            "full_name" => "Yoruba"
            ],
            [
            "short_name" => "zap",
            "full_name" => "Zapotec"
            ],
            [
            "short_name" => "zen",
            "full_name" => "Zenaga"
            ],
            [
            "short_name" => "zha",
            "full_name" => "Zhuang (Chuang)"
            ],
            [
            "short_name" => "zul",
            "full_name" => "Zulu"
            ],
            [
            "short_name" => "zun",
            "full_name" => "Zuni"
            ]
        ];

        $this->table('language')->insert($languages)->save();


        $translations = [
            [
                'value' => '寿司',
                'term_id' => 1,
                'language_id' => 3,
                'user_id' => 1
            ],
            [
                'value' => '塔科',
                'term_id' => 2,
                'language_id' => 2,
                'user_id' => 1
            ],
            [
                'value' => 'タコス',
                'term_id' => 2,
                'language_id' => 3,
                'user_id' => 1
            ]
        ];

        $this->table('translation')->insert($translations)->save();
    }

    public function down() {
        $this->execute("DELETE FROM user");
        $this->execute("DELETE FROM glossary");
        $this->execute("DELETE FROM term");
        $this->execute("DELETE FROM translation");
        $this->execute("DELETE FROM language");
    }
}
