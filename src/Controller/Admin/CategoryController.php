<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }

    #[Route('/{id}/edit', name: 'edit', methods:['GET', 'POST'])]
    public function edit(Request $request, Category $category, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'success',
                'Your category has been updated!'
            );
            $category->setSlug($slugger->slug($category->getName())->lower());
            $categoryRepository->add($category, true);

            return $this->redirectToRoute('admin_categories_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/categories/edit.html.twig', compact('category', 'form'));
    }

    #[Route('/new', name: 'new', methods:['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository, SluggerInterface $slugger): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'success',
                'Your category has been created!'
            );
            $category->setSlug($slugger->slug($category->getName())->lower());
            $categoryRepository->add($category, true);

            return $this->redirectToRoute('admin_categories_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('admin/categories/new.html.twig', compact('category', 'form'));
    }
}
