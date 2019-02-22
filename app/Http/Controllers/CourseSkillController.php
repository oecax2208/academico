<?php

namespace App\Http\Controllers;

use App\Models\Skills\Skill;
use App\Models\Course;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;

class CourseSkillController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:evaluation.edit']);
    }



    public function exportCourseSyllabus(Course $course)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        
        // Course general info
        $section = $phpWord->addSection();
        
        $section->addText('Cours : ' . $course->name);
        
        $section->addText('Session : ' . $course->period->name);
        
        $section->addText("Enseignant(e) : " . $course->teacher->name);
        
        $section->addTextBreak();
        
        
        // Course skills
        $level = "";
        $type = "";

        foreach ($course->skills as $s => $skill)
        {
            if ($skill->level->name != $level)
            {
                $level = $skill->level->name;
                
                $section->addText('Niveau ' . $level);
            }
            
            if ($skill->skill_type->name != $type) {
                $type = $skill->skill_type->name;
                
                $section->addText($type);
            }
            
            $section->addListItem($skill->name);
        }

        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        header("Content-type: application/msword");
        header("Cache-Control: no-store, no-cache");
        header('Content-Disposition: attachment; filename="document.docx"');

        $objWriter->save("php://output");
        exit;

    }

    /**
     * Display the specified course skills list.
     */
    public function show(Course $course)
    {
        $skills = $course->skills;

        return view('skills.course', compact('course', 'skills'));
    }

}
