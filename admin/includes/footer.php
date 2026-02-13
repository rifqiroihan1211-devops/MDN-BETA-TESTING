            </div> <!-- End page-content -->
            
            <footer class="admin-footer">
                <div class="footer-content">
                    <div class="copyright">
                        © <?= date('Y') ?> Masjid Digital Network. All rights reserved.
                    </div>
                    <div class="footer-links">
                        <a href="#">Dokumentasi</a>
                        <a href="#">Bantuan</a>
                        <a href="#">Tentang</a>
                    </div>
                </div>
            </footer>
        </div> <!-- End main-content -->
    </div> <!-- End admin-wrapper -->
    
    <script src="assets/js/admin.js"></script>
    <?php if (isset($extra_js)): ?>
        <?= $extra_js ?>
    <?php endif; ?>
</body>
</html>
