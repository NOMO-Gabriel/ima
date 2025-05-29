<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des départements par leur code pour un accès facile
        $departments = DB::table('departments')->pluck('id', 'code')->all();

        $coursesToSeed = [];

        // Helper function to add courses
        // $salleIdentifier est utilisé pour créer des codes de cours uniques
        $addCourses = function (
            string $salleIntitule,
            string $formationsRegroupeesPretty, // Pour le titre/description
            string $salleIdentifier,          // Pour le code du cours
            array $matieresWithDeptCodes,     // [['dept_code' => 'CODE', 'title_part' => 'Nom Matière'], ...]
            string $phaseSuffix,              // ex: P1, P2, P3
            string $academyType             // 'AFS' ou 'AFL' pour choisir le bon dept Anglais/CG
        ) use (&$coursesToSeed, $departments) {

            foreach ($matieresWithDeptCodes as $matiereInfo) {
                $deptCode = $matiereInfo['dept_code'];
                $courseTitlePart = $matiereInfo['title_part'];

                // Ajustement pour Anglais et Culture Générale basé sur l'académie
                if ($deptCode === 'ANG_GENERIC') {
                    $deptCode = ($academyType === 'AFS') ? 'ANG' : 'ANG_AFL';
                }
                if ($deptCode === 'CG_GENERIC') {
                    $deptCode = ($academyType === 'AFS') ? 'CG' : 'CULT_GEN';
                }

                if (!isset($departments[$deptCode])) {
                    $this->command->warn("Département avec code '{$deptCode}' non trouvé pour la matière '{$courseTitlePart}'. Cours ignoré.");
                    continue;
                }

                $courseCode = strtoupper(Str::slug($deptCode . '_' . $salleIdentifier . '_' . $phaseSuffix, '_'));
                // Assurer l'unicité si plusieurs cours du même département pour la même salle/formation (peu probable ici)
                // Pour l'instant, on suppose que dept_code + salleIdentifier + phaseSuffix est unique.

                $coursesToSeed[] = [
                    'department_id' => $departments[$deptCode],
                    'code' => $courseCode,
                    'title' => $courseTitlePart . ' (' . $salleIntitule . ' - ' . $formationsRegroupeesPretty . ')',
                    'description' => 'Cours de ' . $courseTitlePart . ' pour la formation ' . $salleIntitule . ' regroupant: ' . $formationsRegroupeesPretty . '.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        };

        // --- ACADEMIE FRANCOPHONE SCIENTIFIQUE ---

        // 1ÈRE PHASE : DU LUNDI 02 JUIN AU SAMEDI 12 JUILLET 2025
        $phase1Suffix = 'P1';
        $academyAFS = 'AFS';

        $addCourses(
            'FORMATION ECOLES D’INGENIERIE 1', 'ENSPY–ENSPD–IUT–ENS–ENSET–LINAFI–IBAF', 'ING1',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
            ],
            $phase1Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLE D’INGENIERIE 2', 'ENSTP–SUP’PTIC–ENSPB–FET–IUT BANDJOUN–EGEM–EGCIM–ISABEE(...ARCH)', 'ING2',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie'],
            ],
            $phase1Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES DE SANTE ET D’INGENIERIE', 'FMSB–IDE–ENSAHV–SBM–FASA–FAVM–ISABEE(...SE)', 'SANTE_ING',
            [
                ['dept_code' => 'BIO', 'title_part' => 'Biologie'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie'],
            ],
            $phase1Suffix, $academyAFS
        );
        // Pour "RÉSISTANCE DES MATÉRIAUX", "ÉLECTRO", "INFORMATIQUE (IUT DOUALA)"
        // Ces matières n'ont pas de département direct dans votre DepartmentSeeder.
        // Si 'RDM', 'ELECTRO' étaient des départements, on les ajouterait.
        // Pour l'instant, nous ne pouvons pas les lier sans département correspondant.
        // Exemple si RDM existait:
        // $addCourses('FORMATION IUT – SPECIALITE GC', 'IUT DOUALA', 'IUT_GC', [['dept_code' => 'RDM', 'title_part' => 'Résistance des Matériaux']], $phase1Suffix, $academyAFS);
        // Pour INFORMATIQUE (IUT DOUALA), on peut utiliser le département INFO existant
        $addCourses(
            'FORMATION IUT SPECIALITE GI – GL – GRT', 'IUT DOUALA', 'IUT_GI_GL_GRT',
            [['dept_code' => 'INFO', 'title_part' => 'Informatique (Spécialité IUT GI/GL/GRT)']],
            $phase1Suffix, $academyAFS
        );


        // 2ÈME PHASE : DU LUNDI 07 JUILLET AU SAMEDI 30 AOUT 2025
        $phase2Suffix = 'P2';
        $addCourses(
            'FORMATION ECOLES D’INGENIERIE 1', 'ENSTP–ENSPM–ENSMIP–EGEM–ISABEE(...ARCH)', 'ING1_P2',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie'],
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES D’INGENIERIE 2 : SUP’PTIC - ENSPD ALTERNANCE', 'SUP’PTIC-ENSPD ALTERNANCE–FET–ENS–ENSET', 'ING2_SUPPTIC_ENSPD_P2',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                // Les cours spécifiques SUP'PTIC:
                ['dept_code' => 'INFO', 'title_part' => 'Informatique (SUP\'PTIC)'],
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais (SUP\'PTIC)'],
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES DE MEDECINE & PARAMEDICALE', 'FMSB–ISH–SBM–FAVM–ISABEE(...SE)', 'MED_PARAMED_P2',
            [
                ['dept_code' => 'BIO', 'title_part' => 'Biologie'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie'], // "CHIMIE (CHIMIE + Anglais TD DF)" -> on prend CHIMIE
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais (TD DF Médecine)'], // On assume que c'est un cours d'anglais
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES D’INGENIERIE 2 : FASA', 'FASA', 'FASA_P2',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques (FASA)'],
                // 'BIOLOGIE VEGETALE' n'a pas de département. Si BIO_VEG existait.
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale (FASA)'],
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES DE SANTE IDE', 'IDE–FMSB–ENSAHV–SBM', 'SANTE_IDE_P2',
            [
                ['dept_code' => 'BIO', 'title_part' => 'Biologie'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie'],
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES D’ENSEIGNEMENT ENS MATHEMATIQUES', 'ENS MATH', 'ENS_MATH_P2',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques (ENS)'],
                ['dept_code' => 'INFO', 'title_part' => 'Informatique (ENS Math)'],
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES D’ENSEIGNEMENT ENS PHYSIQUE CHIMIE', 'ENS PHYS-CHIM', 'ENS_PC_P2',
            [
                ['dept_code' => 'PHYS', 'title_part' => 'Physique (ENS)'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie (ENS)'],
            ],
            $phase2Suffix, $academyAFS
        );
        $addCourses(
            'FORMATION ECOLES D’ENSEIGNEMENT ENS BIOLOGIE', 'ENS BIO', 'ENS_BIO_P2',
            [
                ['dept_code' => 'BIO', 'title_part' => 'Biologie (ENS)'], // BILOGOGIE typo dans doc
                // 'SVT' n'a pas de département. Si SVT existait.
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie (ENS Biologie)'],
            ],
            $phase2Suffix, $academyAFS
        );
        // DOUBLE FORMATION: Ces cours sont spécifiques et potentiellement partagés
        // Si GÉOLOGIE (GEOL) existait comme département
        // $addCourses('DOUBLE FORMATION 2 : FMSB – INGENIEUR (ENSTP)', 'FMSB–INGENIEUR(ENSTP)', 'DF_FMSB_ENSTP_P2', [['dept_code' => 'MATHS', 'title_part' => 'Mathématiques (DF FMSB-ENSTP)']], $phase2Suffix, $academyAFS);
        // $addCourses('DOUBLE FORMATION 3 : FMSB – INGENIEUR (EGEM–ENSPM–ENSMIP)', 'FMSB–ING(EGEM-ENSPM-ENSMIP)', 'DF_FMSB_EGEM_P2', [['dept_code' => 'GEOL', 'title_part' => 'Géologie (DF FMSB-ING EGEM)']], $phase2Suffix, $academyAFS);


        // 3ÈME PHASE : DU LUNDI 01 AOUT AU SAMEDI 04 OCTOBRE 2025
        $phase3Suffix = 'P3';
        $addCourses(
            'FORMATION FACULTE DE MEDECINE', 'FMSB', 'FMSB_P3',
            [
                ['dept_code' => 'BIO', 'title_part' => 'Biologie'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie'],
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
            ],
            $phase3Suffix, $academyAFS
        );
        // Pour ESMV, SBM, ENSTMO, etc. beaucoup de matières comme SVT, MATHS (mélange)
        // On va ajouter ceux qui ont un département clair.
        $addCourses(
            'FORMATION ECOLES DE SANTE 1', 'ESMV', 'ESMV_P3',
            [
                ['dept_code' => 'BIO', 'title_part' => 'Biologie (ESMV)'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique (ESMV)'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie (ESMV)'],
                ['dept_code' => 'MATHS', 'title_part' => 'Maths (ESMV)'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale (ESMV)'],
            ],
            $phase3Suffix, $academyAFS
        );
         $addCourses(
            'FORMATION ECOLES D’INGENIERIE 1', 'ENSTMO–ISABEE(...ARCH), ENSPD ALTERNANCE', 'ING1_ENSTMO_ISABEE_P3',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Maths (Rédaction et QCMs)'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
            ],
            $phase3Suffix, $academyAFS
        );
        // SVT n'est pas un département défini.
        // MATIERE: SVT, MATHS, PHYSIQUE, CHIMIE, CULTURE GENERALE pour ESTM, ENSPM...
        $addCourses(
            'FORMATION ECOLES D’INGENIERIE 4', 'ESTM (Cursus Sc & Tech), ENSPM (GC, ENREM, HYMAE, INFOTEL)', 'ING4_ESTM_ENSPM_P3',
            [
                ['dept_code' => 'MATHS', 'title_part' => 'Maths (ESTM/ENSPM)'],
                ['dept_code' => 'PHYS', 'title_part' => 'Physique (ESTM/ENSPM)'],
                ['dept_code' => 'CHIM', 'title_part' => 'Chimie (ESTM/ENSPM)'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale (ENSPM Uniquement)'],
            ],
            $phase3Suffix, $academyAFS
        );


        // --- ACADEMIE FRANCOPHONE LITTERAIRE ---
        $academyAFL = 'AFL';

        // 1ÈRE PHASE
        $addCourses(
            'FORMATION ECOLES D’INFORMATIQUE', 'AHN–IAI–IBAI', 'INFO_AHN_IAI_P1',
            [
                ['dept_code' => 'INFO', 'title_part' => 'Informatique'],
                ['dept_code' => 'MATHS', 'title_part' => 'Mathématiques'], // Le département MATHS est AFS, mais peut-être utilisé ici ? Ou MATHS_GEN? Optons pour MATHS_GEN.
                // ['dept_code' => 'MATHS_GEN', 'title_part' => 'Mathématiques Générales'],
                ['dept_code' => 'CULT_NUM', 'title_part' => 'Culture Générale du Numérique'],
            ],
            $phase1Suffix, $academyAFL
        );
         $addCourses(
            'FORMATION ECOLES DE MANAGEMENT', 'ESSEC - HICM', 'MANAGEMENT_ESSEC_HICM_P1',
            [
                ['dept_code' => 'MATHS_GEN', 'title_part' => 'Mathématiques Générales'],
                ['dept_code' => 'MATHS_FIN', 'title_part' => 'Mathématiques Financières'],
                ['dept_code' => 'PROB_STAT', 'title_part' => 'Probabilités – Statistiques'],
                ['dept_code' => 'DISS_ECO', 'title_part' => 'Dissertation Économique'],
            ],
            $phase1Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE COMMUNICATION', 'ESSTIC - ASMAC', 'COMM_ESSTIC_ASMAC_P1',
            [
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                ['dept_code' => 'SYNTH_DOS', 'title_part' => 'Synthèse de Dossier'],
            ],
            $phase1Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE GESTION, JEUNESSE & SPORT', 'SAINT JEAN - INJS – ENSTMO (SGMP), SUP’PTIC (CPT/IPT) – INUCASTY', 'GEST_JS_P1',
            [
                // 'MATHÉMATIQUES' -> Lequel? MATHS_GEN?
                ['dept_code' => 'MATHS_GEN', 'title_part' => 'Mathématiques'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                ['dept_code' => 'SYNTH_DOC', 'title_part' => 'Synthèse de Documents'],
            ],
            $phase1Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE GESTION & DE DROIT', 'UCAC (FSSG/FSJP) – DOUANE – ENIEG', 'GEST_DROIT_P1',
            [
                ['dept_code' => 'LOGIQUE', 'title_part' => 'Logique'],
                ['dept_code' => 'REDAC', 'title_part' => 'Rédaction'],
                ['dept_code' => 'DISSERT', 'title_part' => 'Dissertation'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                ['dept_code' => 'COMP_TEXT', 'title_part' => 'Compréhension de Texte'],
            ],
            $phase1Suffix, $academyAFL
        );

        // 2ÈME PHASE LITTERAIRE
        $addCourses(
            'FORMATION ECOLES D\'INFORMATIQUE', 'AHN (ENSPM - IBAI GAROUA) - IAI', 'INFO_AHN_IAI_P2',
            [
                ['dept_code' => 'INFO', 'title_part' => 'Informatique'],
                ['dept_code' => 'MATHS_GEN', 'title_part' => 'Mathématiques'], // Ou MATHS?
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                // BILINGUISME n'a pas de département défini
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE GESTION, JEUNESSE & SPORT', 'SAINT JEAN – INJS - CENAJES', 'GEST_JS_CENAJES_P2',
            [
                ['dept_code' => 'MATHS_GEN', 'title_part' => 'Mathématiques'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                ['dept_code' => 'SYNTH_DOC', 'title_part' => 'Synthèse de Documents'],
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais'],
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE MANAGEMENT', 'ESSEC - HICM - SAINT JEAN - PREPA VOGT - INUCASTY', 'MANAGEMENT_MULTI_P2',
            [
                ['dept_code' => 'MATHS_GEN', 'title_part' => 'Mathématiques Générales'],
                ['dept_code' => 'MATHS_FIN', 'title_part' => 'Mathématiques Financières'],
                ['dept_code' => 'PROB_STAT', 'title_part' => 'Probabilités – Statistiques'],
                ['dept_code' => 'DISS_ECO', 'title_part' => 'Dissertation Économique'],
                ['dept_code' => 'ART_ORAT', 'title_part' => 'Art Oratoire'],
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE COMMUNICATION', 'ESSTIC – INUCASTY – ASMAC', 'COMM_MULTI_P2',
            [
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                ['dept_code' => 'SYNTH_DOS', 'title_part' => 'Synthèse de Dossier'],
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES DE GESTION ET DE DROIT', 'UCAC (FSSG/FSJP) - DOUANE', 'GEST_DROIT_UCAC_DOUANE_P2',
            [
                ['dept_code' => 'LOGIQUE', 'title_part' => 'Logique'],
                ['dept_code' => 'REDAC', 'title_part' => 'Rédaction'],
                ['dept_code' => 'DISSERT', 'title_part' => 'Dissertation'],
                ['dept_code' => 'CG_GENERIC', 'title_part' => 'Culture Générale'],
                ['dept_code' => 'COMP_TEXT', 'title_part' => 'Compréhension de Texte'],
                ['dept_code' => 'METHOD', 'title_part' => 'Méthodologie'],
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES D’ENSEIGNEMENT ENS LETTRES MODERNES', 'ENS LETTRES MODERNES', 'ENS_LM_P2',
            [
                ['dept_code' => 'LITT_LANG', 'title_part' => 'Littérature et Langue'],
                // 'LANGUE ET DISSERTATION' n'a pas de département.
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES D’ENSEIGNEMENT ENS LETTRES BILINGUE', 'ENS LETTRES BILINGUE', 'ENS_LB_P2',
            [
                ['dept_code' => 'ANG_GENERIC', 'title_part' => 'Anglais'], // ANGLAIS ET METHODOLOGIE
                ['dept_code' => 'METHOD', 'title_part' => 'Méthodologie'],
            ],
            $phase2Suffix, $academyAFL
        );
        $addCourses(
            'FORMATION ECOLES D’ENSEIGNEMENT ENS HISTOIRE GEOGRAPHIE', 'ENS HISTOIRE GEOGRAPHIE', 'ENS_HG_P2',
            [
                ['dept_code' => 'HIST', 'title_part' => 'Histoire'],
                ['dept_code' => 'GEOG', 'title_part' => 'Géographie'],
                ['dept_code' => 'METHOD', 'title_part' => 'Méthodologie'],
            ],
            $phase2Suffix, $academyAFL
        );

        // Filtrer les doublons potentiels basés sur le code du cours (au cas où)
        $uniqueCourses = [];
        foreach ($coursesToSeed as $course) {
            $uniqueCourses[$course['code']] = $course;
        }
        $coursesToSeed = array_values($uniqueCourses);


        if (!empty($coursesToSeed)) {
            DB::table('courses')->insert($coursesToSeed);
            $this->command->info("✅ " . count($coursesToSeed) . " cours créés avec succès.");
        } else {
            $this->command->info("ℹ️ Aucun cours à créer ou tous les départements mappés n'ont pas été trouvés.");
        }
    }
}
